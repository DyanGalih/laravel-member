<?php
/**
 * Created by LazyCrud - @DyanGalih <dyan.galih@gmail.com>
 */

namespace WebAppId\Member\Repositories;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\QueryException;
use Illuminate\Pagination\LengthAwarePaginator;
use WebAppId\Lazy\Tools\Lazy;
use WebAppId\Lazy\Traits\RepositoryTrait;
use WebAppId\Member\Models\Member;
use WebAppId\Member\Repositories\Requests\MemberRepositoryRequest;

/**
 * @author:
 * Date: 16:28:29
 * Time: 2020/09/16
 * Trait MemberRepositoryTrait
 * @package WebAppId\Member\Repositories
 */
trait MemberRepositoryTrait
{
    use RepositoryTrait;

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
            report($queryException);
            return null;
        }
    }

    /**
     * @inheritDoc
     */
    public function update(string $code, MemberRepositoryRequest $memberRepositoryRequest, Member $member): ?Member
    {
        $member = $member->where('code', $code)->first();
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
    public function delete(string $code, Member $member): bool
    {
        $member = $member->where('members.code', $code)->first();
        if ($member != null) {
            return $member->delete();
        } else {
            return false;
        }
    }

    /**
     * @inheritDoc
     */
    public function get(Member $member, int $length = 12, string $q = null): LengthAwarePaginator
    {
        return $this
            ->getJoin($member)
            ->when($q != null, function ($query) use ($q) {
                return $this->getFilter($query, $q);
            })
            ->paginate($length, $this->getColumn())
            ->appends(request()->all());
    }

    protected function getFilter(Builder $query, string $q)
    {
        return $query->where('members.code', 'LIKE', '%' . $q . '%');
    }

    /**
     * @inheritDoc
     */
    public function getCount(Member $member, string $q = null): int
    {
        return $this
            ->getJoin($member)
            ->when($q != null, function ($query) use ($q) {
                return $this->getFilter($query, $q);
            })
            ->count();
    }

    /**
     * @inheritDoc
     */
    public function getByCode(string $code, Member $member): ?Member
    {
        return $this
            ->getJoin($member)
            ->where('members.code', $code)
            ->first($this->getColumn());

    }

    /**
     * @inheritDoc
     */
    public function getByCodeList(string $code, Member $member, int $length = 12): LengthAwarePaginator
    {
        return $this
            ->getJoin($member)
            ->where('members.code', $code)
            ->paginate($length, $this->getColumn())
            ->appends(request()->input());
    }

    /**
     * @inheritDoc
     */
    public function getByContentId(int $contentId, Member $member): ?Member
    {

        return $this
            ->getJoin($member)
            ->where('members.content_id', $contentId)
            ->first($this->getColumn());
    }

    /**
     * @inheritDoc
     */
    public function getByContentIdList(int $contentId, Member $member, int $length = 12): LengthAwarePaginator
    {
        return $this
            ->getJoin($member)
            ->where('members.content_id', $contentId)
            ->paginate($length, $this->getColumn())
            ->appends(request()->input());
    }

    /**
     * @inheritDoc
     */
    public function getByCreatorId(int $creatorId, Member $member): ?Member
    {

        return $this
            ->getJoin($member)
            ->where('members.creator_id', $creatorId)
            ->first($this->getColumn());

    }

    /**
     * @inheritDoc
     */
    public function getByCreatorIdList(int $creatorId, Member $member, int $length = 12): LengthAwarePaginator
    {
        return $this
            ->getJoin($member)
            ->where('members.creator_id', $creatorId)
            ->paginate($length, $this->getColumn())
            ->appends(request()->input());
    }

    /**
     * @inheritDoc
     */
    public function getByEmail(string $email, Member $member): ?Member
    {

        return $this
            ->getJoin($member)
            ->where('members.email', $email)
            ->first($this->getColumn());

    }

    /**
     * @inheritDoc
     */
    public function getByEmailList(string $email, Member $member, int $length = 12): LengthAwarePaginator
    {
        return $this
            ->getJoin($member)
            ->where('members.email', $email)
            ->paginate($length, $this->getColumn())
            ->appends(request()->input());
    }

    /**
     * @inheritDoc
     */
    public function getByIdentityTypeId(int $identityTypeId, Member $member): ?Member
    {

        return $this
            ->getJoin($member)
            ->where('members.identity_type_id', $identityTypeId)
            ->first($this->getColumn());

    }

    /**
     * @inheritDoc
     */
    public function getByIdentityTypeIdList(int $identityTypeId, Member $member, int $length = 12): LengthAwarePaginator
    {
        return $this
            ->getJoin($member)
            ->where('members.identity_type_id', $identityTypeId)
            ->paginate($length, $this->getColumn())
            ->appends(request()->input());
    }

    /**
     * @inheritDoc
     */
    public function getByLanguageId(int $languageId, Member $member): ?Member
    {

        return $this
            ->getJoin($member)
            ->where('members.language_id', $languageId)
            ->first($this->getColumn());

    }

    /**
     * @inheritDoc
     */
    public function getByLanguageIdList(int $languageId, Member $member, int $length = 12): LengthAwarePaginator
    {
        return $this
            ->getJoin($member)
            ->where('members.language_id', $languageId)
            ->paginate($length, $this->getColumn())
            ->appends(request()->input());
    }

    /**
     * @inheritDoc
     */
    public function getByOwnerId(int $ownerId, Member $member): ?Member
    {

        return $this
            ->getJoin($member)
            ->where('members.owner_id', $ownerId)
            ->first($this->getColumn());

    }

    /**
     * @inheritDoc
     */
    public function getByOwnerIdList(int $ownerId, Member $member, int $length = 12): LengthAwarePaginator
    {
        return $this
            ->getJoin($member)
            ->where('members.owner_id', $ownerId)
            ->paginate($length, $this->getColumn())
            ->appends(request()->input());
    }

    /**
     * @inheritDoc
     */
    public function getByProfileId(int $profileId, Member $member): ?Member
    {

        return $this
            ->getJoin($member)
            ->where('members.profile_id', $profileId)
            ->first($this->getColumn());

    }

    /**
     * @inheritDoc
     */
    public function getByProfileIdList(int $profileId, Member $member, int $length = 12): LengthAwarePaginator
    {
        return $this
            ->getJoin($member)
            ->where('members.profile_id', $profileId)
            ->paginate($length, $this->getColumn())
            ->appends(request()->input());
    }

    /**
     * @inheritDoc
     */
    public function getByTimezoneId(int $timezoneId, Member $member): ?Member
    {

        return $this
            ->getJoin($member)
            ->where('members.timezone_id', $timezoneId)
            ->first($this->getColumn());

    }

    /**
     * @inheritDoc
     */
    public function getByTimezoneIdList(int $timezoneId, Member $member, int $length = 12): LengthAwarePaginator
    {
        return $this
            ->getJoin($member)
            ->where('members.timezone_id', $timezoneId)
            ->paginate($length, $this->getColumn())
            ->appends(request()->input());
    }

    /**
     * @inheritDoc
     */
    public function getByUserId(int $userId, Member $member): ?Member
    {

        return $this
            ->getJoin($member)
            ->where('members.user_id', $userId)
            ->first($this->getColumn());

    }

    /**
     * @inheritDoc
     */
    public function getByUserIdList(int $userId, Member $member, int $length = 12): LengthAwarePaginator
    {
        return $this
            ->getJoin($member)
            ->where('members.user_id', $userId)
            ->paginate($length, $this->getColumn())
            ->appends(request()->input());
    }

    /**
     * @inheritDoc
     */
    public function getById(int $id, Member $member): ?Member
    {

        return $this
            ->getJoin($member)
            ->where('members.id', $id)
            ->first($this->getColumn());

    }

    /**
     * @inheritDoc
     */
    public function getByIdList(int $id, Member $member, int $length = 12): LengthAwarePaginator
    {
        return $this
            ->getJoin($member)
            ->where('members.id', $id)
            ->paginate($length, $this->getColumn())
            ->appends(request()->input());
    }

    /**
     * @inheritDoc
     */
    public function getByContentCode(string $code, Member $member): ?Member
    {

        return $this
            ->getJoin($member)
            ->where('contents.code', $code)
            ->first($this->getColumn());

    }

    /**
     * @inheritDoc
     */
    public function getByContentCodeList(string $code, Member $member, int $length = 12): LengthAwarePaginator
    {
        return $this
            ->getJoin($member)
            ->where('contents.code', $code)
            ->paginate($length, $this->getColumn())
            ->appends(request()->input());
    }

    /**
     * @inheritDoc
     */
    public function getByContentKeyword(string $keyword, Member $member): ?Member
    {

        return $this
            ->getJoin($member)
            ->where('contents.keyword', $keyword)
            ->first($this->getColumn());

    }

    /**
     * @inheritDoc
     */
    public function getByContentKeywordList(string $keyword, Member $member, int $length = 12): LengthAwarePaginator
    {
        return $this
            ->getJoin($member)
            ->where('contents.keyword', $keyword)
            ->paginate($length, $this->getColumn())
            ->appends(request()->input());
    }

    /**
     * @inheritDoc
     */
    public function getByContentOgDescription(string $ogDescription, Member $member): ?Member
    {

        return $this
            ->getJoin($member)
            ->where('contents.og_description', $ogDescription)
            ->first($this->getColumn());

    }

    /**
     * @inheritDoc
     */
    public function getByContentOgDescriptionList(string $ogDescription, Member $member, int $length = 12): LengthAwarePaginator
    {
        return $this
            ->getJoin($member)
            ->where('contents.og_description', $ogDescription)
            ->paginate($length, $this->getColumn())
            ->appends(request()->input());
    }

    /**
     * @inheritDoc
     */
    public function getByContentOgTitle(string $ogTitle, Member $member): ?Member
    {

        return $this
            ->getJoin($member)
            ->where('contents.og_title', $ogTitle)
            ->first($this->getColumn());

    }

    /**
     * @inheritDoc
     */
    public function getByContentOgTitleList(string $ogTitle, Member $member, int $length = 12): LengthAwarePaginator
    {
        return $this
            ->getJoin($member)
            ->where('contents.og_title', $ogTitle)
            ->paginate($length, $this->getColumn())
            ->appends(request()->input());
    }

    /**
     * @inheritDoc
     */
    public function getByContentTitle(string $title, Member $member): ?Member
    {

        return $this
            ->getJoin($member)
            ->where('contents.title', $title)
            ->first($this->getColumn());

    }

    /**
     * @inheritDoc
     */
    public function getByContentTitleList(string $title, Member $member, int $length = 12): LengthAwarePaginator
    {
        return $this
            ->getJoin($member)
            ->where('contents.title', $title)
            ->paginate($length, $this->getColumn())
            ->appends(request()->input());
    }

    /**
     * @inheritDoc
     */
    public function getByUserEmail(string $email, Member $member): ?Member
    {

        return $this
            ->getJoin($member)
            ->where('users.email', $email)
            ->first($this->getColumn());
    }

    /**
     * @inheritDoc
     */
    public function getByUserEmailList(string $email, Member $member, int $length = 12): LengthAwarePaginator
    {
        return $this
            ->getJoin($member)
            ->where('users.email', $email)
            ->paginate($length, $this->getColumn())
            ->appends(request()->input());
    }

    /**
     * @inheritDoc
     */
    public function getByIdentityTypeName(string $name, Member $member): ?Member
    {

        return $this
            ->getJoin($member)
            ->where('identity_types.name', $name)
            ->first($this->getColumn());

    }

    /**
     * @inheritDoc
     */
    public function getByIdentityTypeNameList(string $name, Member $member, int $length = 12): LengthAwarePaginator
    {
        return $this
            ->getJoin($member)
            ->where('identity_types.name', $name)
            ->paginate($length, $this->getColumn())
            ->appends(request()->input());
    }

    /**
     * @inheritDoc
     */
    public function getByLanguageCode(string $code, Member $member): ?Member
    {

        return $this
            ->getJoin($member)
            ->where('languages.code', $code)
            ->first($this->getColumn());

    }

    /**
     * @inheritDoc
     */
    public function getByLanguageCodeList(string $code, Member $member, int $length = 12): LengthAwarePaginator
    {
        return $this
            ->getJoin($member)
            ->where('languages.code', $code)
            ->paginate($length, $this->getColumn())
            ->appends(request()->input());
    }

    /**
     * @inheritDoc
     */
    public function getByTimeZoneCode(string $code, Member $member): ?Member
    {

        return $this
            ->getJoin($member)
            ->where('time_zones.code', $code)
            ->first($this->getColumn());

    }

    /**
     * @inheritDoc
     */
    public function getByTimeZoneCodeList(string $code, Member $member, int $length = 12): LengthAwarePaginator
    {
        return $this
            ->getJoin($member)
            ->where('time_zones.code', $code)
            ->paginate($length, $this->getColumn())
            ->appends(request()->input());
    }

}
