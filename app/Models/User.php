<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function problem() {
        return $this->hasMany(Problem::class);
    }

    public function searchHistory() {
        return $this->hasMany(SearchHistory::class);
    }

    public function reply() {
        return $this->hasMany(ProblemReply::class);
    }

    public function like() {
        return $this->hasMany(Like::class);
    }

    public function userProblemLikes() {
        return $this->belongsToMany(Problem::class, 'problem_likes', 'user_id', 'problem_id')->withTimestamps();
    }

    public function following() {
        return $this->belongsToMany(User::class, 'follows', 'follower_id', 'following_id')->withTimestamps();
    }

    public function followers() {
        return $this->belongsToMany(User::class, 'follows', 'following_id', 'follower_id')->withTimestamps();
    }

    public function follow(User $user) {
        
        $result;

        if(auth()->check()){
            
            $isFollowing = auth()->user()->following()->where('following_id', $user->id)->exists();

            if ($isFollowing) {
                // フォロー関係の解除
                $result = auth()->user()->following()->detach($user);
                // フォロー解除後のリダイレクトやレスポンスなどの処理
                return $result;

            } else {
                // フォロー関係の作成
                $result = auth()->user()->following()->attach($user);
                // フォロー後のリダイレクトやレスポンスなどの処理
                return $result;
            }
        }
        return $result;
    }

    public function problemLike(Problem $problem) {
        $result;

        if(auth()->check()) {

            $isLiking = auth()->user()->userProblemLikes()->where('problem_id', $problem->id)->exists();

            if($isLiking) {
                $result = auth()->user()->userProblemLikes()->detach($problem);

                return $result;
            } else {
                $result = auth()->user()->userProblemLikes()->attach($problem);

                return $result;
            }

            return $result;

        }
    }

    public function deleteFollow(User $user) {

        $result = auth()->user()->following()->detach($uesr);

        return $result;

    }
}
