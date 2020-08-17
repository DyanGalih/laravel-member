<?php
/**
 * Created by LazyCrud - @DyanGalih <dyan.galih@gmail.com>
 */

namespace WebAppId\Member\Repositories;

use Illuminate\Support\Facades\DB;
use Ramsey\Uuid\Uuid;
use WebAppId\Member\Models\Member;
use WebAppId\Member\Repositories\Contracts\MemberRepositoryContract;
use WebAppId\Member\Repositories\Requests\MemberRepositoryRequest;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\QueryException;
use Illuminate\Pagination\LengthAwarePaginator;
use WebAppId\DDD\Tools\Lazy;

/**
 * @author: Dyan Galih<dyan.galih@gmail.com>
 * Date: 03:24:51
 * Time: 2020/05/09
 * Class MemberRepository
 * @package WebAppId\Member\Repositories
 */
class MemberRepository implements MemberRepositoryContract
{
    /**
     * @inheritDoc
     */
    public function store(MemberRepositoryRequest $memberRepositoryRequest, Member $member): ?Member
    {
        try {
            $member = Lazy::copy($memberRepositoryRequest, $member);
            $member->code = Uuid::uuid4()->toString();
            $member->save();
            return $member;
        } catch (QueryException $queryException) {
            report($queryException);
            dd($queryException);
            return null;
        }
    }

    public function getJoin(Member $member, string $q = null): Builder
    {
        return $member
            ->join('users as users', 'members.creator_id', 'users.id')
            ->join('identity_types as identity_types', 'members.identity_type_id', 'identity_types.id')
            ->join('languages as languages', 'members.language_id', 'languages.id')
            ->join('users as owner_users', 'members.owner_id', 'owner_users.id')
            ->join('time_zones as time_zones', 'members.timezone_id', 'time_zones.id')
            ->join('users as user_users', 'members.user_id', 'user_users.id')
            ->join('contents', 'members.content_id', 'contents.id')
            ->join('files', 'contents.default_image', 'files.id')
            ->when($q != null, function ($query) use ($q) {
                return $query->where('members.name', 'LIKE', '%' . $q . '%');
            });
    }

    /**
     * @return array
     */
    protected function getColumn(): array
    {
        return [
            'members.id',
            'members.code',
            'members.identity_type_id',
            'members.identity',
            'members.name',
            'members.email',
            'members.phone',
            'members.phone_alternative',
            'members.sex',
            'members.dob',
            'members.timezone_id',
            'members.language_id',
            'members.user_id',
            'members.creator_id',
            'members.owner_id',
            'members.created_at',
            'members.updated_at',
            'users.name AS creator_name',
            'users.email AS creator_email',
            'identity_types.name AS identity_name',
            'languages.code AS language_code',
            'languages.name AS language_name',
            'owner_users.name AS owner_name',
            'contents.id AS content_id',
            'contents.default_image AS default_image',
            'contents.title AS content_title',
            'contents.code AS content_code',
            'contents.keyword AS content_keyword',
            'contents.description AS content_description',
            DB::raw('REPLACE("' . route('file.ori', 'file_name') . '", "file_name" , files.name) AS file_uri'),
            'files.name AS file_name',
            'files.description AS file_description',
            'files.alt AS file_alt',
            'files.path AS file_path',
            'time_zones.code AS time_zone_code',
            'time_zones.name AS time_zone_name',
            'time_zones.minute AS time_zone_minute',
            'user_users.name AS user_name',
            'user_users.email AS user_email'
        ];
    }

    /**
     * @inheritDoc
     */
    public function update(string $code,
                           MemberRepositoryRequest $memberRepositoryRequest,
                           Member $member,
                           int $ownerId = null): ?Member
    {
        $member = $member
            ->where('code', $code)
            ->when($ownerId != null, function ($query) use ($ownerId) {
                return $query->where('members.owner_id', $ownerId);
            })
            ->first();
        if ($member != null) {
            try {
                $member = Lazy::copy($memberRepositoryRequest, $member);
                $member->save();
                return $member;
            } catch (QueryException $queryException) {
                report($queryException);
            }
        }
        return $member;
    }

    /**
     * @inheritDoc
     */
    public function getByCode(string $code,
                              Member $member,
                              int $ownerId = null): ?Member
    {
        return $this->getJoin($member)
            ->where('members.code', $code)
            ->when($ownerId != null, function ($query) use ($ownerId) {
                return $query->where('members.owner_id', $ownerId);
            })
            ->first($this->getColumn());
    }

    /**
     * @inheritDoc
     */
    public function getById(int $id,
                            Member $member,
                            int $ownerId = null): ?Member
    {
        return $this
            ->getJoin($member)
            ->when($ownerId != null, function ($query) use ($ownerId) {
                return $query->where('members.owner_id', $ownerId);
            })
            ->find($id, $this->getColumn());
    }

    /**
     * @inheritDoc
     */
    public function delete(int $id,
                           Member $member,
                           int $ownerId = null): bool
    {
        $member = $member
            ->when($ownerId != null, function ($query) use ($ownerId) {
                return $query->where('members.owner_id', $ownerId);
            })->find($id);
        if ($member != null) {
            return $member->delete();
        } else {
            return false;
        }
    }

    /**
     * @inheritDoc
     */
    public function get(Member $member,
                        int $length = 12,
                        string $q = null,
                        int $ownerId = null): LengthAwarePaginator
    {
        return $this
            ->getJoin($member, $q)
            ->when($ownerId != null, function ($query) use ($ownerId) {
                return $query->where('members.owner_id', $ownerId);
            })
            ->paginate($length, $this->getColumn());
    }

    /**
     * @inheritDoc
     */
    public function getCount(Member $member,
                             string $q = null,
                             int $ownerId = null): int
    {
        return $this
            ->getJoin($member, $q)
            ->when($ownerId != null, function ($query) use ($ownerId) {
                return $query->where('members.owner_id', $ownerId);
            })
            ->count();
    }

    /**
     * @inheritDoc
     */
    public function checkAvailableIdentity(Member $member, string $identity, string $memberId = null): bool
    {

        $result = $member
            ->where('identity', $identity)
            ->when($memberId != null, function ($query) use ($memberId) {
                return $query->where('id', $memberId);
            })->first();
        return $result == null;
    }

    /**
     * @inheritDoc
     */
    public function checkAvailableEmail(Member $member, string $email, string $memberId = null): bool
    {
        $result = $member
            ->where('email', $email)
            ->when($memberId != null, function ($query) use ($memberId) {
                return $query->where('id', $memberId);
            })->first();

        return $result == null;
    }
}
