<?php
/**
 * Created by LazyCrud - @DyanGalih <dyan.galih@gmail.com>
 */

namespace WebAppId\Member\Repositories;

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
            $member->save();
            return $member;
        } catch (QueryException $queryException) {
            dd($queryException);
            report($queryException);
            return null;
        }
    }

    /**
     * @param Member $member
     * @param string|null $q
     * @return Builder
     */
    protected function getColumn(Member $member, string $q = null): Builder
    {
        return $member
            ->select
                (
                'members.id',
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
                'members.picture_id',
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
                'files.name',
                'files.description',
                'files.alt',
                'files.path',
                'time_zones.code AS time_zone_code',
                'time_zones.name AS time_zone_name',
                'time_zones.minute AS time_zone_minute',
                'user_users.name AS user_name',
                'user_users.email AS user_email'
                )
                ->join('users as users', 'members.creator_id', 'users.id')
                ->join('identity_types as identity_types', 'members.identity_type_id', 'identity_types.id')
                ->join('languages as languages', 'members.language_id', 'languages.id')
                ->join('users as owner_users', 'members.owner_id', 'owner_users.id')
                ->join('files as files', 'members.picture_id', 'files.id')
                ->join('time_zones as time_zones', 'members.timezone_id', 'time_zones.id')
                ->join('users as user_users', 'members.user_id', 'user_users.id')
            ->when($q != null, function ($query) use ($q) {
                    return $query->where('members.name', 'LIKE', '%' . $q . '%');
                });
    }

    /**
     * @inheritDoc
     */
    public function update(int $id, MemberRepositoryRequest $memberRepositoryRequest, Member $member): ?Member
    {
        $member = $this->getById($id, $member);
        if($member!=null){
            try {
                $member = Lazy::copy($memberRepositoryRequest, $member);
                $member->save();
                return $member;
            }catch (QueryException $queryException){
                report($queryException);
            }
        }
        return $member;
    }

    /**
     * @inheritDoc
     */
    public function getById(int $id, Member $member): ?Member
    {
        return $this->getColumn($member)->find($id);
    }

    /**
     * @inheritDoc
     */
    public function delete(int $id, Member $member): bool
    {
        $member = $this->getById($id, $member);
        if($member!=null){
            return $member->delete();
        }else{
            return false;
        }
    }

    /**
     * @inheritDoc
     */
    public function get(Member $member, int $length = 12, string $q = null): LengthAwarePaginator
    {
        return $this
            ->getColumn($member, $q)
            ->paginate($length);
    }

    /**
     * @inheritDoc
     */
    public function getCount(Member $member, string $q = null): int
    {
        return $this
            ->getColumn($member, $q)
            ->count();
    }
}
