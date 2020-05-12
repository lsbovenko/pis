<?php

namespace App\Widgets;

use Illuminate\Contracts\View\View;
use Spatie\Menu\Laravel\MenuFacade as Menu;
use Illuminate\Support\Facades\Auth;
use App\Models\Auth\Role;

/**
 * Class Navbar
 *
 * @package App\Widgets
 */
class Navbar
{
    /**
     * @param View $view
     */
    public function compose(View $view)
    {
        Menu::macro(
            'main',
            function () {
                $menu = Menu::new()->addClass('dropdown-menu');
                $user = Auth::user();
                if (isset($user)) {
                    $menu
                        ->route('faq', trans('ideas.about_system'))
                        ->route('main', trans('ideas.ideas'))
                        ->route('priority-board', trans('ideas.priority_list'))
                        ->route('my-ideas', trans('ideas.my_ideas'));
                    if ($user->hasRole(Role::ROLE_SUPERADMIN)) {
                        $menu
                            ->route('pending-review', trans('ideas.awaiting'))
                            ->route('declined', trans('ideas.rejected_menu'))
                            ->route('users.index', trans('ideas.users_menu'))
                            ->route('categories.index', trans('ideas.categories'));
                    }
                    $menu
                        ->route('add-idea', '+ ' . trans('ideas.add_idea'))
                        ->setActiveFromRequest()
                        ->setAttributes(
                            [
                            'role' => 'menu',
                            'aria-labelledby' => 'dLabel'
                            ]
                        );
                }

                return $menu;
            }
        );
    }
}
