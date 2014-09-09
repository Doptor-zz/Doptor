<?php namespace Services;
/*
=================================================
CMS Name  :  DOPTOR
CMS Version :  v1.2
Available at :  www.doptor.org
Copyright : Copyright (coffee) 2011 - 2014 Doptor. All rights reserved.
License : GNU/GPL, visit LICENSE.txt
Description :  Doptor is Opensource CMS.
===================================================
*/
use App, Exception, Input, Str, View, Redirect, Request, Response;
use Sentry;
use Menus;

use Menu;
use MenuCategory;
use MenuPosition;

class MenuManager {

    public static function generate($menu_type, $menu_class='')
    {
        static::fixOldMenuCategories();

        $category = MenuPosition::where('alias', '=', $menu_type)
                                    ->with('menus')
                                    ->first();

        if (!$category) {
            // $menu_render = "The menu type '$menu_type' not found";
            $menu_render = "";
        } else {
            $menu_items = $category->menus()
                            ->published()
                            ->where('parent', '=', 0)
                            ->orderBy('order', 'asc')
                            ->get();

            if ($menu_items->count() > 0) {
                Menus::handler($menu_type, array('class' => $menu_class))->hydrate(function() use ($menu_items) {

                    return $menu_items;

                }, function($children, $item) {
                    if ($item->groups()->count() == 0 // If menu has no group,the menu is public
                            || (Sentry::check() // Check if the user is logged in
                                && in_array(Sentry::getUser()->getGroups()->first()->name, $item->selected_groups('name'))) // Check if the current user group lies in the selected group for menu
                            ) {
                        $image = ($item->icon != '') ? "<img src='" . url($item->icon) . "'>" : '';

                        $item->title = "<div class='menu-icon'>{$image}</div>{$item->title}";

                        $menus = MenuManager::findChildren($item);

                        $children->add($item->link(), $item->title, $menus, (!$item->same_window) ? array('target'=>'_blank') : array());
                    }

                }, 'id', 'parent');

                $menu_render = Menus::handler($menu_type)->render();
            } else {
                $menu_render = '';
            }

        }

        return $menu_render;
    }

    /**
     * Fixes the menu position for menu entries which were added
     * before the menu_positions table were introduced
     */
    public static function fixOldMenuCategories()
    {
        $menus = Menu::where('position', 0)->get();

        foreach ($menus as $menu) {
            $menu_category = $menu->cat->menu_type;
            $menu_position = MenuPosition::where('alias', $menu_category)->first();
            if ($menu_position) {
                $menu->position = $menu_position->id;
                $menu->save();
            }
        }
    }

    /**
     * Find all the children of an item
     * @param  Item $item
     * @return Item
     */
    public static function findChildren($item)
    {
        $child_menus = Menu::where('parent', '=', $item->id)
                            ->orderBy('order', 'asc')
                            ->get();

        if ($child_menus->count() > 0) {
            $menus = Menus::items();
            foreach ($child_menus as $child) {
                $inner_child = static::findChildren($child);

                $menus->add($child->link(), $child->title, $inner_child, (!$child->same_window) ? array('target'=>'_blank') : array());
            }
        } else {
            $menus = null;
        }

        return $menus;
    }

    public static function findCurrentMenu()
    {
        $request_path = (Request::path() != 'home') ? Request::path() : '/';

        if (str_contains($request_path, 'wrapper/')) {
            $segments = Request::segments();
            $id = last($segments);
            $menu = Menu::find($id);
        } else {
            $menu = Menu::published()
                    ->where(function($query) use($request_path) {
                        $query->where('link', '=', $request_path)
                                ->orWhere('link_manual', '=', $request_path);
                    })
                    ->where('display_text', '<>', '')
                    ->first();
        }

        return $menu;
    }

    /**
     * Get the title from the display text in the menu or get the specified title
     * @param  string $title Specified Title
     * @return string
     */
    public static function getTitle($title)
    {
        $menu = static::findCurrentMenu();

        if ($menu) {
            return $menu->display_text;
        } else {
            return $title;
        }
    }

    public static function isImageShown($value='')
    {
        $menu = static::findCurrentMenu();

        if ($menu) {
            return $menu->show_image;
        } else {
            return true;
        }
    }
}
