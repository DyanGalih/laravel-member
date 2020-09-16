<?php
/**
 * Created by LazyCrud - @DyanGalih <dyan.galih@gmail.com>
 */

namespace WebAppId\Member\Repositories;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\QueryException;
use Illuminate\Pagination\LengthAwarePaginator;
use WebAppId\Lazy\Tools\Lazy;
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
            ->getJoin($member, $q)
            ->paginate($length, $this->getColumn())
            ->appends(request()->all());
    }

    /**
     * @param Member $member
     * @param string|null $q
     * @return Builder
     */
    protected function getJoin(Member $member, string $q = null): Builder
    {
        return $member
            ->join('contents as contents', 'members.content_id', 'contents.id')
            ->join('users as users', 'members.creator_id', 'users.id')
            ->join('identity_types as identity_types', 'members.identity_type_id', 'identity_types.id')
            ->join('languages as languages', 'members.language_id', 'languages.id')
            ->join('users as owner_users', 'members.owner_id', 'owner_users.id')
            ->join('users as profile_users', 'members.profile_id', 'profile_users.id')
            ->join('time_zones as time_zones', 'members.timezone_id', 'time_zones.id')
            ->join('users as user_users', 'members.user_id', 'user_users.id')
            ->when($q != null, function ($query) use ($q) {
                return $query->where('members.code', 'LIKE', '%' . $q . '%');
            });
    }

    /**
     * @return array
     */
    protected function getColumn(): array
    {
        return
            [
                'members.id',
                'members.profile_id',
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
                'members.content_id',
                'members.user_id',
                'members.creator_id',
                'members.owner_id',
                'members.created_at',
                'members.updated_at',
                'contents.id as contents_id',
                'contents.title',
                'contents.code as contents_code',
                'contents.description',
                'contents.keyword',
                'contents.og_title',
                'contents.og_description',
                'contents.default_image',
                'contents.status_id',
                'contents.language_id as contents_language_id',
                'contents.time_zone_id',
                'contents.publish_date',
                'contents.additional_info',
                'contents.content',
                'contents.creator_id as contents_creator_id',
                'contents.owner_id as contents_owner_id',
                'contents.user_id as contents_user_id',
                'contents.created_at as contents_created_at',
                'contents.updated_at as contents_updated_at',
                'users.id as users_id',
                'users.name as users_name',
                'users.email as users_email',
                'users.email_verified_at',
                'users.password',
                'users.api_token',
                'users.remember_token',
                'users.created_at as users_created_at',
                'users.updated_at as users_updated_at',
                'users.status_id as users_status_id',
                'identity_types.id as identity_types_id',
                'identity_types.name as identity_types_name',
                'identity_types.user_id as identity_types_user_id',
                'identity_types.created_at as identity_types_created_at',
                'identity_types.updated_at as identity_types_updated_at',
                'languages.id as languages_id',
                'languages.code as languages_code',
                'languages.name as languages_name',
                'languages.image_id',
                'languages.user_id as languages_user_id',
                'languages.created_at as languages_created_at',
                'languages.updated_at as languages_updated_at',
                'owner_users.id as owner_users_id',
                'owner_users.name as owner_users_name',
                'owner_users.email as owner_users_email',
                'owner_users.email_verified_at as owner_users_email_verified_at',
                'owner_users.password as owner_users_password',
                'owner_users.api_token as owner_users_api_token',
                'owner_users.remember_token as owner_users_remember_token',
                'owner_users.created_at as owner_users_created_at',
                'owner_users.updated_at as owner_users_updated_at',
                'owner_users.status_id as owner_users_status_id',
                'profile_users.id as profile_users_id',
                'profile_users.name as profile_users_name',
                'profile_users.email as profile_users_email',
                'profile_users.email_verified_at as profile_users_email_verified_at',
                'profile_users.password as profile_users_password',
                'profile_users.api_token as profile_users_api_token',
                'profile_users.remember_token as profile_users_remember_token',
                'profile_users.created_at as profile_users_created_at',
                'profile_users.updated_at as profile_users_updated_at',
                'profile_users.status_id as profile_users_status_id',
                'time_zones.id as time_zones_id',
                'time_zones.code as time_zones_code',
                'time_zones.name as time_zones_name',
                'time_zones.minute',
                'time_zones.user_id as time_zones_user_id',
                'time_zones.created_at as time_zones_created_at',
                'time_zones.updated_at as time_zones_updated_at',
                'user_users.id as user_users_id',
                'user_users.name as user_users_name',
                'user_users.email as user_users_email',
                'user_users.email_verified_at as user_users_email_verified_at',
                'user_users.password as user_users_password',
                'user_users.api_token as user_users_api_token',
                'user_users.remember_token as user_users_remember_token',
                'user_users.created_at as user_users_created_at',
                'user_users.updated_at as user_users_updated_at',
                'user_users.status_id as user_users_status_id'
            ];
    }

    /**
     * @inheritDoc
     */
    public function getCount(Member $member, string $q = null): int
    {
        return $this
            ->getJoin($member, $q)
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
