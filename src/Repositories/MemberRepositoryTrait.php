<?php
/**
 * Created by LazyCrud - @DyanGalih <dyan.galih@gmail.com>
 */

namespace WebAppId\Member\Repositories;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\QueryException;
use Illuminate\Pagination\LengthAwarePaginator;
use WebAppId\Content\Models\Content;
use WebAppId\Content\Models\Language;
use WebAppId\Content\Models\TimeZone;
use WebAppId\Lazy\Models\Join;
use WebAppId\Lazy\Tools\Lazy;
use WebAppId\Lazy\Traits\RepositoryTrait;
use WebAppId\Member\Models\IdentityType;
use WebAppId\Member\Models\Member;
use WebAppId\Member\Models\MemberType;
use WebAppId\Member\Repositories\Requests\MemberRepositoryRequest;

/**
 * @author:
 * Date: 18:40:09
 * Time: 2020/10/08
 * Trait MemberRepositoryTrait
 * @package WebAppId\Member\Repositories
 */
trait MemberRepositoryTrait
{

    use RepositoryTrait;

    protected function init(){
        $contents = app()->make(Join::class);
        $contents->class = Content::class;
        $contents->foreign = 'members.content_id';
        $contents->type = 'inner';
        $contents->primary = 'contents.id';
        $this->joinTable['contents'] = $contents;

        $users = app()->make(Join::class);
        $users->class = User::class;
        $users->foreign = 'members.creator_id';
        $users->type = 'inner';
        $users->primary = 'users.id';
        $this->joinTable['users'] = $users;

        $identity_types = app()->make(Join::class);
        $identity_types->class = IdentityType::class;
        $identity_types->foreign = 'members.identity_type_id';
        $identity_types->type = 'inner';
        $identity_types->primary = 'identity_types.id';
        $this->joinTable['identity_types'] = $identity_types;

        $languages = app()->make(Join::class);
        $languages->class = Language::class;
        $languages->foreign = 'members.language_id';
        $languages->type = 'inner';
        $languages->primary = 'languages.id';
        $this->joinTable['languages'] = $languages;

        $owner_users = app()->make(Join::class);
        $owner_users->class = User::class;
        $owner_users->foreign = 'members.owner_id';
        $owner_users->type = 'inner';
        $owner_users->primary = 'owner_users.id';
        $this->joinTable['owner_users'] = $owner_users;

        $profile_users = app()->make(Join::class);
        $profile_users->class = User::class;
        $profile_users->foreign = 'members.profile_id';
        $profile_users->type = 'left';
        $profile_users->primary = 'profile_users.id';
        $this->joinTable['profile_users'] = $profile_users;

        $time_zones = app()->make(Join::class);
        $time_zones->class = TimeZone::class;
        $time_zones->foreign = 'members.timezone_id';
        $time_zones->type = 'inner';
        $time_zones->primary = 'time_zones.id';
        $this->joinTable['time_zones'] = $time_zones;

        $member_types = app()->make(Join::class);
        $member_types->class = MemberType::class;
        $member_types->foreign = 'members.type_id';
        $member_types->type = 'left';
        $member_types->primary = 'member_types.id';
        $this->joinTable['member_types'] = $member_types;

        $user_users = app()->make(Join::class);
        $user_users->class = User::class;
        $user_users->foreign = 'members.user_id';
        $user_users->type = 'inner';
        $user_users->primary = 'user_users.id';
        $this->joinTable['user_users'] = $user_users;

    }

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
        if($member != null){
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
    public function delete(string $code, Member $member): bool
    {
        $member = $member->where('members.code',$code)->first();
        if($member!=null){
            return $member->delete();
        }else{
            return false;
        }
    }

    /**
     * @param Builder $query
     * @param string $q
     * @return Builder
     */
    protected Function getFilter(Builder $query, string $q)
    {
        return $query->where('members.code', 'LIKE', '%' . $q . '%')
        ->orWhere('members.email', 'LIKE', '%' . $q . '%')
        ->orWhere('members.name', 'LIKE', '%' . $q . '%')
        ->orWhere('members.phone', 'LIKE', '%' . $q . '%')
        ->orWhere('members.sex', 'LIKE', '%' . $q . '%');
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
    public function getByCode(string $code, Member $member):? Member
    {
        return $this
            ->getJoin($member)
            ->where('members.code', '=', $code )
            ->first($this->getColumn());
    }

    /**
     * @inheritDoc
     */
    public function getByCodeList(string $code, Member $member, string $q = null, int $length = 12): LengthAwarePaginator
    {
        return $this
            ->getJoin($member)
            ->when($q != null, function ($query) use ($q) {
                return $this->getFilter($query, $q);
            })
            ->where('members.code', '=', $code )
            ->paginate($length, $this->getColumn())
            ->appends(request()->input());
    }

    /**
     * @inheritDoc
     */
    public function getByCreatorIdTypeId(int $creatorId, int $typeId, Member $member):? Member
    {
        return $this
            ->getJoin($member)
            ->where('members.creator_id', '=', $creatorId )
            ->where('members.type_id', '=', $typeId )
            ->first($this->getColumn());
    }

    /**
     * @inheritDoc
     */
    public function getByCreatorIdTypeIdList(int $creatorId, int $typeId, Member $member, string $q = null, int $length = 12): LengthAwarePaginator
    {
        return $this
            ->getJoin($member)
            ->when($q != null, function ($query) use ($q) {
                return $this->getFilter($query, $q);
            })
            ->where('members.creator_id', '=', $creatorId )
            ->where('members.type_id', '=', $typeId )
            ->paginate($length, $this->getColumn())
            ->appends(request()->input());
    }

    /**
     * @inheritDoc
     */
    public function getByEmail(string $email, Member $member):? Member
    {
        return $this
            ->getJoin($member)
            ->where('members.email', '=', $email )
            ->first($this->getColumn());
    }

    /**
     * @inheritDoc
     */
    public function getByEmailList(string $email, Member $member, string $q = null, int $length = 12): LengthAwarePaginator
    {
        return $this
            ->getJoin($member)
            ->when($q != null, function ($query) use ($q) {
                return $this->getFilter($query, $q);
            })
            ->where('members.email', '=', $email )
            ->paginate($length, $this->getColumn())
            ->appends(request()->input());
    }

    /**
     * @inheritDoc
     */
    public function getByName(string $name, Member $member):? Member
    {
        return $this
            ->getJoin($member)
            ->where('members.name', '=', $name )
            ->first($this->getColumn());
    }

    /**
     * @inheritDoc
     */
    public function getByNameList(string $name, Member $member, string $q = null, int $length = 12): LengthAwarePaginator
    {
        return $this
            ->getJoin($member)
            ->when($q != null, function ($query) use ($q) {
                return $this->getFilter($query, $q);
            })
            ->where('members.name', '=', $name )
            ->paginate($length, $this->getColumn())
            ->appends(request()->input());
    }

    /**
     * @inheritDoc
     */
    public function getByOwnerIdTypeId(int $ownerId, int $typeId, Member $member):? Member
    {
        return $this
            ->getJoin($member)
            ->where('members.owner_id', '=', $ownerId )
            ->where('members.type_id', '=', $typeId )
            ->first($this->getColumn());
    }

    /**
     * @inheritDoc
     */
    public function getByOwnerIdTypeIdList(int $ownerId, int $typeId, Member $member, string $q = null, int $length = 12): LengthAwarePaginator
    {
        return $this
            ->getJoin($member)
            ->when($q != null, function ($query) use ($q) {
                return $this->getFilter($query, $q);
            })
            ->where('members.owner_id', '=', $ownerId )
            ->where('members.type_id', '=', $typeId )
            ->paginate($length, $this->getColumn())
            ->appends(request()->input());
    }

    /**
     * @inheritDoc
     */
    public function getByPhone(string $phone, Member $member):? Member
    {
        return $this
            ->getJoin($member)
            ->where('members.phone', '=', $phone )
            ->first($this->getColumn());
    }

    /**
     * @inheritDoc
     */
    public function getByPhoneList(string $phone, Member $member, string $q = null, int $length = 12): LengthAwarePaginator
    {
        return $this
            ->getJoin($member)
            ->when($q != null, function ($query) use ($q) {
                return $this->getFilter($query, $q);
            })
            ->where('members.phone', '=', $phone )
            ->paginate($length, $this->getColumn())
            ->appends(request()->input());
    }

    /**
     * @inheritDoc
     */
    public function getBySex(string $sex, Member $member):? Member
    {
        return $this
            ->getJoin($member)
            ->where('members.sex', '=', $sex )
            ->first($this->getColumn());
    }

    /**
     * @inheritDoc
     */
    public function getBySexList(string $sex, Member $member, string $q = null, int $length = 12): LengthAwarePaginator
    {
        return $this
            ->getJoin($member)
            ->when($q != null, function ($query) use ($q) {
                return $this->getFilter($query, $q);
            })
            ->where('members.sex', '=', $sex )
            ->paginate($length, $this->getColumn())
            ->appends(request()->input());
    }

    /**
     * @inheritDoc
     */
    public function getById(int $id, Member $member):? Member
    {
        return $this
            ->getJoin($member)
            ->where('members.id', '=', $id )
            ->first($this->getColumn());
    }

    /**
     * @inheritDoc
     */
    public function getByIdList(int $id, Member $member, string $q = null, int $length = 12): LengthAwarePaginator
    {
        return $this
            ->getJoin($member)
            ->when($q != null, function ($query) use ($q) {
                return $this->getFilter($query, $q);
            })
            ->where('members.id', '=', $id )
            ->paginate($length, $this->getColumn())
            ->appends(request()->input());
    }

    /**
     * @inheritDoc
     */
    public function getByContentCode(string $code, Member $member):? Member
    {
        return $this
            ->getJoin($member)
            ->where('contents.code', '=', $code )
            ->first($this->getColumn());
    }

    /**
     * @inheritDoc
     */
    public function getByContentCodeList(string $code, Member $member, string $q = null, int $length = 12): LengthAwarePaginator
    {
        return $this
            ->getJoin($member)
            ->when($q != null, function ($query) use ($q) {
                return $this->getFilter($query, $q);
            })
            ->where('contents.code', '=', $code )
            ->paginate($length, $this->getColumn())
            ->appends(request()->input());
    }

    /**
     * @inheritDoc
     */
    public function getByContentKeyword(string $keyword, Member $member):? Member
    {
        return $this
            ->getJoin($member)
            ->where('contents.keyword', '=', $keyword )
            ->first($this->getColumn());
    }

    /**
     * @inheritDoc
     */
    public function getByContentKeywordList(string $keyword, Member $member, string $q = null, int $length = 12): LengthAwarePaginator
    {
        return $this
            ->getJoin($member)
            ->when($q != null, function ($query) use ($q) {
                return $this->getFilter($query, $q);
            })
            ->where('contents.keyword', '=', $keyword )
            ->paginate($length, $this->getColumn())
            ->appends(request()->input());
    }

    /**
     * @inheritDoc
     */
    public function getByContentOgDescription(string $ogDescription, Member $member):? Member
    {
        return $this
            ->getJoin($member)
            ->where('contents.og_description', '=', $ogDescription )
            ->first($this->getColumn());
    }

    /**
     * @inheritDoc
     */
    public function getByContentOgDescriptionList(string $ogDescription, Member $member, string $q = null, int $length = 12): LengthAwarePaginator
    {
        return $this
            ->getJoin($member)
            ->when($q != null, function ($query) use ($q) {
                return $this->getFilter($query, $q);
            })
            ->where('contents.og_description', '=', $ogDescription )
            ->paginate($length, $this->getColumn())
            ->appends(request()->input());
    }

    /**
     * @inheritDoc
     */
    public function getByContentOgTitle(string $ogTitle, Member $member):? Member
    {
        return $this
            ->getJoin($member)
            ->where('contents.og_title', '=', $ogTitle )
            ->first($this->getColumn());
    }

    /**
     * @inheritDoc
     */
    public function getByContentOgTitleList(string $ogTitle, Member $member, string $q = null, int $length = 12): LengthAwarePaginator
    {
        return $this
            ->getJoin($member)
            ->when($q != null, function ($query) use ($q) {
                return $this->getFilter($query, $q);
            })
            ->where('contents.og_title', '=', $ogTitle )
            ->paginate($length, $this->getColumn())
            ->appends(request()->input());
    }

    /**
     * @inheritDoc
     */
    public function getByContentTitle(string $title, Member $member):? Member
    {
        return $this
            ->getJoin($member)
            ->where('contents.title', '=', $title )
            ->first($this->getColumn());
    }

    /**
     * @inheritDoc
     */
    public function getByContentTitleList(string $title, Member $member, string $q = null, int $length = 12): LengthAwarePaginator
    {
        return $this
            ->getJoin($member)
            ->when($q != null, function ($query) use ($q) {
                return $this->getFilter($query, $q);
            })
            ->where('contents.title', '=', $title )
            ->paginate($length, $this->getColumn())
            ->appends(request()->input());
    }

    /**
     * @inheritDoc
     */
    public function getByContentId(int $id, Member $member):? Member
    {
        return $this
            ->getJoin($member)
            ->where('contents.id', '=', $id )
            ->first($this->getColumn());
    }

    /**
     * @inheritDoc
     */
    public function getByContentIdList(int $id, Member $member, string $q = null, int $length = 12): LengthAwarePaginator
    {
        return $this
            ->getJoin($member)
            ->when($q != null, function ($query) use ($q) {
                return $this->getFilter($query, $q);
            })
            ->where('contents.id', '=', $id )
            ->paginate($length, $this->getColumn())
            ->appends(request()->input());
    }

    /**
     * @inheritDoc
     */
    public function getByUserApiToken(string $apiToken, Member $member):? Member
    {
        return $this
            ->getJoin($member)
            ->where('users.api_token', '=', $apiToken )
            ->first($this->getColumn());
    }

    /**
     * @inheritDoc
     */
    public function getByUserApiTokenList(string $apiToken, Member $member, string $q = null, int $length = 12): LengthAwarePaginator
    {
        return $this
            ->getJoin($member)
            ->when($q != null, function ($query) use ($q) {
                return $this->getFilter($query, $q);
            })
            ->where('users.api_token', '=', $apiToken )
            ->paginate($length, $this->getColumn())
            ->appends(request()->input());
    }

    /**
     * @inheritDoc
     */
    public function getByUserEmail(string $email, Member $member):? Member
    {
        return $this
            ->getJoin($member)
            ->where('users.email', '=', $email )
            ->first($this->getColumn());
    }

    /**
     * @inheritDoc
     */
    public function getByUserEmailList(string $email, Member $member, string $q = null, int $length = 12): LengthAwarePaginator
    {
        return $this
            ->getJoin($member)
            ->when($q != null, function ($query) use ($q) {
                return $this->getFilter($query, $q);
            })
            ->where('users.email', '=', $email )
            ->paginate($length, $this->getColumn())
            ->appends(request()->input());
    }

    /**
     * @inheritDoc
     */
    public function getByUserId(int $id, Member $member):? Member
    {
        return $this
            ->getJoin($member)
            ->where('users.id', '=', $id )
            ->first($this->getColumn());
    }

    /**
     * @inheritDoc
     */
    public function getByUserIdList(int $id, Member $member, string $q = null, int $length = 12): LengthAwarePaginator
    {
        return $this
            ->getJoin($member)
            ->when($q != null, function ($query) use ($q) {
                return $this->getFilter($query, $q);
            })
            ->where('users.id', '=', $id )
            ->paginate($length, $this->getColumn())
            ->appends(request()->input());
    }

    /**
     * @inheritDoc
     */
    public function getByIdentityTypeName(string $name, Member $member):? Member
    {
        return $this
            ->getJoin($member)
            ->where('identity_types.name', '=', $name )
            ->first($this->getColumn());
    }

    /**
     * @inheritDoc
     */
    public function getByIdentityTypeNameList(string $name, Member $member, string $q = null, int $length = 12): LengthAwarePaginator
    {
        return $this
            ->getJoin($member)
            ->when($q != null, function ($query) use ($q) {
                return $this->getFilter($query, $q);
            })
            ->where('identity_types.name', '=', $name )
            ->paginate($length, $this->getColumn())
            ->appends(request()->input());
    }

    /**
     * @inheritDoc
     */
    public function getByIdentityTypeId(int $id, Member $member):? Member
    {
        return $this
            ->getJoin($member)
            ->where('identity_types.id', '=', $id )
            ->first($this->getColumn());
    }

    /**
     * @inheritDoc
     */
    public function getByIdentityTypeIdList(int $id, Member $member, string $q = null, int $length = 12): LengthAwarePaginator
    {
        return $this
            ->getJoin($member)
            ->when($q != null, function ($query) use ($q) {
                return $this->getFilter($query, $q);
            })
            ->where('identity_types.id', '=', $id )
            ->paginate($length, $this->getColumn())
            ->appends(request()->input());
    }

    /**
     * @inheritDoc
     */
    public function getByLanguageCode(string $code, Member $member):? Member
    {
        return $this
            ->getJoin($member)
            ->where('languages.code', '=', $code )
            ->first($this->getColumn());
    }

    /**
     * @inheritDoc
     */
    public function getByLanguageCodeList(string $code, Member $member, string $q = null, int $length = 12): LengthAwarePaginator
    {
        return $this
            ->getJoin($member)
            ->when($q != null, function ($query) use ($q) {
                return $this->getFilter($query, $q);
            })
            ->where('languages.code', '=', $code )
            ->paginate($length, $this->getColumn())
            ->appends(request()->input());
    }

    /**
     * @inheritDoc
     */
    public function getByLanguageId(int $id, Member $member):? Member
    {
        return $this
            ->getJoin($member)
            ->where('languages.id', '=', $id )
            ->first($this->getColumn());
    }

    /**
     * @inheritDoc
     */
    public function getByLanguageIdList(int $id, Member $member, string $q = null, int $length = 12): LengthAwarePaginator
    {
        return $this
            ->getJoin($member)
            ->when($q != null, function ($query) use ($q) {
                return $this->getFilter($query, $q);
            })
            ->where('languages.id', '=', $id )
            ->paginate($length, $this->getColumn())
            ->appends(request()->input());
    }

    /**
     * @inheritDoc
     */
    public function getByOwnerUserApiToken(string $apiToken, Member $member):? Member
    {
        return $this
            ->getJoin($member)
            ->where('owner_users.api_token', '=', $apiToken )
            ->first($this->getColumn());
    }

    /**
     * @inheritDoc
     */
    public function getByOwnerUserApiTokenList(string $apiToken, Member $member, string $q = null, int $length = 12): LengthAwarePaginator
    {
        return $this
            ->getJoin($member)
            ->when($q != null, function ($query) use ($q) {
                return $this->getFilter($query, $q);
            })
            ->where('owner_users.api_token', '=', $apiToken )
            ->paginate($length, $this->getColumn())
            ->appends(request()->input());
    }

    /**
     * @inheritDoc
     */
    public function getByOwnerUserEmail(string $email, Member $member):? Member
    {
        return $this
            ->getJoin($member)
            ->where('owner_users.email', '=', $email )
            ->first($this->getColumn());
    }

    /**
     * @inheritDoc
     */
    public function getByOwnerUserEmailList(string $email, Member $member, string $q = null, int $length = 12): LengthAwarePaginator
    {
        return $this
            ->getJoin($member)
            ->when($q != null, function ($query) use ($q) {
                return $this->getFilter($query, $q);
            })
            ->where('owner_users.email', '=', $email )
            ->paginate($length, $this->getColumn())
            ->appends(request()->input());
    }

    /**
     * @inheritDoc
     */
    public function getByOwnerUserId(int $id, Member $member):? Member
    {
        return $this
            ->getJoin($member)
            ->where('owner_users.id', '=', $id )
            ->first($this->getColumn());
    }

    /**
     * @inheritDoc
     */
    public function getByOwnerUserIdList(int $id, Member $member, string $q = null, int $length = 12): LengthAwarePaginator
    {
        return $this
            ->getJoin($member)
            ->when($q != null, function ($query) use ($q) {
                return $this->getFilter($query, $q);
            })
            ->where('owner_users.id', '=', $id )
            ->paginate($length, $this->getColumn())
            ->appends(request()->input());
    }

    /**
     * @inheritDoc
     */
    public function getByProfileUserApiToken(string $apiToken, Member $member):? Member
    {
        return $this
            ->getJoin($member)
            ->where('profile_users.api_token', '=', $apiToken )
            ->first($this->getColumn());
    }

    /**
     * @inheritDoc
     */
    public function getByProfileUserApiTokenList(string $apiToken, Member $member, string $q = null, int $length = 12): LengthAwarePaginator
    {
        return $this
            ->getJoin($member)
            ->when($q != null, function ($query) use ($q) {
                return $this->getFilter($query, $q);
            })
            ->where('profile_users.api_token', '=', $apiToken )
            ->paginate($length, $this->getColumn())
            ->appends(request()->input());
    }

    /**
     * @inheritDoc
     */
    public function getByProfileUserEmail(string $email, Member $member):? Member
    {
        return $this
            ->getJoin($member)
            ->where('profile_users.email', '=', $email )
            ->first($this->getColumn());
    }

    /**
     * @inheritDoc
     */
    public function getByProfileUserEmailList(string $email, Member $member, string $q = null, int $length = 12): LengthAwarePaginator
    {
        return $this
            ->getJoin($member)
            ->when($q != null, function ($query) use ($q) {
                return $this->getFilter($query, $q);
            })
            ->where('profile_users.email', '=', $email )
            ->paginate($length, $this->getColumn())
            ->appends(request()->input());
    }

    /**
     * @inheritDoc
     */
    public function getByProfileUserId(int $id, Member $member):? Member
    {
        return $this
            ->getJoin($member)
            ->where('profile_users.id', '=', $id )
            ->first($this->getColumn());
    }

    /**
     * @inheritDoc
     */
    public function getByProfileUserIdList(int $id, Member $member, string $q = null, int $length = 12): LengthAwarePaginator
    {
        return $this
            ->getJoin($member)
            ->when($q != null, function ($query) use ($q) {
                return $this->getFilter($query, $q);
            })
            ->where('profile_users.id', '=', $id )
            ->paginate($length, $this->getColumn())
            ->appends(request()->input());
    }

    /**
     * @inheritDoc
     */
    public function getByTimeZoneCode(string $code, Member $member):? Member
    {
        return $this
            ->getJoin($member)
            ->where('time_zones.code', '=', $code )
            ->first($this->getColumn());
    }

    /**
     * @inheritDoc
     */
    public function getByTimeZoneCodeList(string $code, Member $member, string $q = null, int $length = 12): LengthAwarePaginator
    {
        return $this
            ->getJoin($member)
            ->when($q != null, function ($query) use ($q) {
                return $this->getFilter($query, $q);
            })
            ->where('time_zones.code', '=', $code )
            ->paginate($length, $this->getColumn())
            ->appends(request()->input());
    }

    /**
     * @inheritDoc
     */
    public function getByTimeZoneId(int $id, Member $member):? Member
    {
        return $this
            ->getJoin($member)
            ->where('time_zones.id', '=', $id )
            ->first($this->getColumn());
    }

    /**
     * @inheritDoc
     */
    public function getByTimeZoneIdList(int $id, Member $member, string $q = null, int $length = 12): LengthAwarePaginator
    {
        return $this
            ->getJoin($member)
            ->when($q != null, function ($query) use ($q) {
                return $this->getFilter($query, $q);
            })
            ->where('time_zones.id', '=', $id )
            ->paginate($length, $this->getColumn())
            ->appends(request()->input());
    }

    /**
     * @inheritDoc
     */
    public function getByMemberTypeName(string $name, Member $member):? Member
    {
        return $this
            ->getJoin($member)
            ->where('member_types.name', '=', $name )
            ->first($this->getColumn());
    }

    /**
     * @inheritDoc
     */
    public function getByMemberTypeNameList(string $name, Member $member, string $q = null, int $length = 12): LengthAwarePaginator
    {
        return $this
            ->getJoin($member)
            ->when($q != null, function ($query) use ($q) {
                return $this->getFilter($query, $q);
            })
            ->where('member_types.name', '=', $name )
            ->paginate($length, $this->getColumn())
            ->appends(request()->input());
    }

    /**
     * @inheritDoc
     */
    public function getByMemberTypeId(int $id, Member $member):? Member
    {
        return $this
            ->getJoin($member)
            ->where('member_types.id', '=', $id )
            ->first($this->getColumn());
    }

    /**
     * @inheritDoc
     */
    public function getByMemberTypeIdList(int $id, Member $member, string $q = null, int $length = 12): LengthAwarePaginator
    {
        return $this
            ->getJoin($member)
            ->when($q != null, function ($query) use ($q) {
                return $this->getFilter($query, $q);
            })
            ->where('member_types.id', '=', $id )
            ->paginate($length, $this->getColumn())
            ->appends(request()->input());
    }

    /**
     * @inheritDoc
     */
    public function getByUserUserApiToken(string $apiToken, Member $member):? Member
    {
        return $this
            ->getJoin($member)
            ->where('user_users.api_token', '=', $apiToken )
            ->first($this->getColumn());
    }

    /**
     * @inheritDoc
     */
    public function getByUserUserApiTokenList(string $apiToken, Member $member, string $q = null, int $length = 12): LengthAwarePaginator
    {
        return $this
            ->getJoin($member)
            ->when($q != null, function ($query) use ($q) {
                return $this->getFilter($query, $q);
            })
            ->where('user_users.api_token', '=', $apiToken )
            ->paginate($length, $this->getColumn())
            ->appends(request()->input());
    }

    /**
     * @inheritDoc
     */
    public function getByUserUserEmail(string $email, Member $member):? Member
    {
        return $this
            ->getJoin($member)
            ->where('user_users.email', '=', $email )
            ->first($this->getColumn());
    }

    /**
     * @inheritDoc
     */
    public function getByUserUserEmailList(string $email, Member $member, string $q = null, int $length = 12): LengthAwarePaginator
    {
        return $this
            ->getJoin($member)
            ->when($q != null, function ($query) use ($q) {
                return $this->getFilter($query, $q);
            })
            ->where('user_users.email', '=', $email )
            ->paginate($length, $this->getColumn())
            ->appends(request()->input());
    }

    /**
     * @inheritDoc
     */
    public function getByUserUserId(int $id, Member $member):? Member
    {
        return $this
            ->getJoin($member)
            ->where('user_users.id', '=', $id )
            ->first($this->getColumn());
    }

    /**
     * @inheritDoc
     */
    public function getByUserUserIdList(int $id, Member $member, string $q = null, int $length = 12): LengthAwarePaginator
    {
        return $this
            ->getJoin($member)
            ->when($q != null, function ($query) use ($q) {
                return $this->getFilter($query, $q);
            })
            ->where('user_users.id', '=', $id )
            ->paginate($length, $this->getColumn())
            ->appends(request()->input());
    }

}
