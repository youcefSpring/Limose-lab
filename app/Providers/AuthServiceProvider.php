<?php

namespace App\Providers;

use App\Models\Project;
use App\Models\ProjectFunding;
use App\Models\Researcher;
use App\Policies\ProjectPolicy;
use App\Policies\ProjectFundingPolicy;
use App\Policies\ResearcherPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Project::class => ProjectPolicy::class,
        ProjectFunding::class => ProjectFundingPolicy::class,
        Researcher::class => ResearcherPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();
    }
}