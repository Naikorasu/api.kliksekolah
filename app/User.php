<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;
use Illuminate\Database\Eloquent\Builder;

class User extends Authenticatable
{
    //use Notifiable;
    use Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'user_groups_id', 'prm_school_units_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function userGroup() {
      return $this->hasOne(UserGroups::class, 'id', 'user_groups_id');
    }

    public function schoolUnit() {
      return $this->hasOne(SchoolUnits::class, 'id', 'prm_school_units_id');
    }

    public function userRoles() {
      return $this->hasMany(UserRoles::class, 'id', 'user_id');
    }

    public function hasAnyUserGroup($userGroups) {
      return null !== $this->userGroup()->whereIn('name', $userGroups)->first();
    }

    public function hasAnySchoolUnit($schoolUnits) {
      return null !== $this->schoolUnit()->whereIn('name', $schoolUnits)->first();
    }

    public function hasUserGroup($userGroup) {
      return null !== $this->userGroup()->where('name', $userGroup)->first();
    }

    public function hasSchoolUnit($schoolUnit) {
      return null !== $this->schoolUnit()->where('name', $schoolUnit)->first();
    }

    public function hasAnyUserRoles($roles) {
      return null !== $this->userRoles()->roles()->whereIn('name', $roles)->first();
    }

    public function hasUserRole($role) {
      return null != $this->userRoles()->roles()->where('name', $role)->first();
    }

    public function authorizeRole($roles) {
      if(is_array($roles)) {
        return $this->hasAnyUserRoles($roles) ||
          abort (401, 'This action is unauthorized');
      }
      return $this->hasUserRole($roles) ||
        abort (401, 'This action is unauthorized');
    }
}
