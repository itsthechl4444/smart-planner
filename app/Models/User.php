<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail; 
use App\Notifications\CustomVerifyEmail;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Task; 
use App\Models\Label;
use App\Models\Project;
use App\Models\ProjectTask;
use App\Models\Debt;
use App\Models\Income;
use App\Models\Account;
use App\Models\Saving;
use App\Models\Expense;
use App\Models\Budget;
use App\Notifications\CustomResetPasswordNotification; 


class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * Send the password reset notification.
     *
     * @param string $token
     * @return void
     */

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

  /**
     * Override the default email verification notification.
     *
     * @return void
     */
    public function sendEmailVerificationNotification()
    {
        $this->notify(new CustomVerifyEmail());
    }

    /**
     * Generate the email verification URL.
     *
     * @return string
     */
    protected function generateVerificationUrl()
    {
        return \URL::temporarySignedRoute(
            'verification.verify',
            \Carbon\Carbon::now()->addMinutes(config('auth.verification.expire', 60)),
            ['id' => $this->id, 'hash' => sha1($this->email)]
        );
    }

     /**
     * Get the tasks for the user.
     */
    public function tasks()
{
    return $this->hasMany(Task::class);
}

 /**
     * Projects owned by the user.
     */
    public function ownedProjects()
    {
        return $this->hasMany(Project::class, 'user_id');
    }

    /**
     * Projects the user is collaborating on.
     */
    public function acceptedCollaborations()
    {
        return $this->belongsToMany(Project::class, 'project_user', 'user_id', 'project_id')
                    ->withPivot('status')
                    ->wherePivot('status', 'accepted')
                    ->withTimestamps();
    }

    /**
     * Projects where the user has pending invitations.
     */
    public function projectsPending()
    {
        return $this->belongsToMany(Project::class, 'project_user', 'user_id', 'project_id')
                    ->withPivot('status')
                    ->wherePivot('status', 'pending')
                    ->withTimestamps();
    }

    /**
     * Projects where the user has declined invitations.
     */
    public function projectsDeclined()
    {
        return $this->belongsToMany(Project::class, 'project_user', 'user_id', 'project_id')
                    ->withPivot('status')
                    ->wherePivot('status', 'declined')
                    ->withTimestamps();
    }

 /**
     * The project tasks assigned to the user.
     */
    public function assignedProjectTasks()
    {
        return $this->hasMany(ProjectTask::class, 'user_id');
    }




    //labels
     public function labels()
    {
        return $this->hasMany(Label::class);
    }

    //accounts
    public function accounts()
{
    return $this->hasMany(Account::class);
}

    //expenses
    public function expenses()
{
    return $this->hasMany(Expense::class);
}

    //incomes
    public function incomes()
    {
        return $this->hasMany(Income::class);
    }

    //debts
        public function debts()
    {
        return $this->hasMany(Debt::class);
    }

    //savings
     public function budgets()
    {
        return $this->hasMany(Budget::class);
    }

    //savings
    public function savings()
    {
        return $this->hasMany(Saving::class);
    } 

    public function financialReminders()
    {
        return $this->hasMany(FinancialReminder::class);
    }
    

   /**
     * Override the default password reset notification.
     *
     * @param  string  $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new CustomResetPasswordNotification($token));
    } 
}
