<?php

namespace App\Providers;


use Illuminate\Support\ServiceProvider;

class RepositoryProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->registerBindings();
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    private function registerBindings()
    {

        $this->app->bind(
            'App\Repositories\AuthorRepository',
            function () {
                $repository = new \App\Repositories\Eloquent\EloquentAuthorRepository(new \App\Models\Author());
                return $repository;
            }
        );
        $this->app->bind(
            'App\Repositories\CategoryRepository',
            function () {
                $repository = new \App\Repositories\Eloquent\EloquentCategoryRepository(new \App\Models\Categories());
                return $repository;
            }
        );
        $this->app->bind(
            'App\Repositories\ChapterRepository',
            function () {
                $repository = new \App\Repositories\Eloquent\EloquentChapterRepository(new \App\Models\Chapters());
                return $repository;
            }
        );
        $this->app->bind(
            'App\Repositories\CommentsRepository',
            function () {
                $repository = new \App\Repositories\Eloquent\EloquentCommentsRepository(new \App\Models\Comments());
                return $repository;
            }
        );
        $this->app->bind(
            'App\Repositories\StoryRepository',
            function () {
                $repository = new \App\Repositories\Eloquent\EloquentStoryRepository(new \App\Models\Stories());
                return $repository;
            }
        );
        $this->app->bind(
            'App\Repositories\UserLoginRepository',
            function () {
                $repository = new \App\Repositories\Eloquent\EloquentUserLoginRepository(new \App\Models\UserLogin());
                return $repository;
            }
        );
        $this->app->bind(
            'App\Repositories\UserRepository',
            function () {
                $repository = new \App\Repositories\Eloquent\EloquentUserRepository(new \App\Models\User());
                return $repository;
            }
        );
        $this->app->bind(
            'App\Repositories\LevelRepository',
            function () {
                $repository = new \App\Repositories\Eloquent\EloquentLevelRepository(new \App\Models\Levels());
                return $repository;
            }
        );
        $this->app->bind(
            'App\Repositories\UserStoryRepository',
            function () {
                $repository = new \App\Repositories\Eloquent\EloquentUserStoryRepository(new \App\Models\UserStory());
                return $repository;
            }
        );
    }
}
