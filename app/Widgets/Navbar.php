<?php

namespace App\Widgets;
use Illuminate\Contracts\View\View;

use Spatie\Menu\Laravel\MenuFacade as Menu;
use Illuminate\Support\Facades\Auth;
use App\Models\Auth\Role;

/**
 * Class Navbar
 * @package App\Widgets
 */
class Navbar {

    /**
     * @param View $view
     */
    public function compose(View $view){

        Menu::macro('main', function () {
            $menu = Menu::new()
                ->addClass('nav navbar-nav')
                ->route('main', 'Идеи')
                ->route('priority-board', 'Приоритетный список');

            $user = Auth::user();
            if (isset($user) && $user->hasRole(Role::ROLE_SUPERADMIN)) {
                $menu
                    ->route('pending-review', 'Ожидающие обзор')
                    ->route('declined', 'Отклоненные')
                    ->route('categories', 'Категории');
            }

            return $menu
                ->route('add-idea', '+ Добавить идею')
                ->setActiveFromRequest();
        });
    }
}