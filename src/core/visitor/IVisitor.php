<?php

/**
 * This file is part of the MarkdownBlog project.
 * This interface enables TODO
 * 
 * MarkdownBlog is a lightweight blog software written in php and twitter bootstrap. 
 * Its purpose is to provide a easy way to share your thoughts without any Database 
 * or special setup needed. 
 *
 * Copyright (C) 2014 Philipp Gamper & Max Schrimpf
 *
 * The project is free software: You can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * The file is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with the project. if not, write to the Free Software Foundation, Inc.
 * 51 Franklin Street, Fifth Floor, Boston, MA 02110-1301 USA.
 */
interface IVisitor
{
    public function visit(AbstractModel $model, $arg, $bool);

    public function container(Container $model, $arg, $bool);
    
    public function typedContainer(TypedContainer $model, $arg, $bool);

    public function composite(Composite $model, $arg, $bool);

    public function collection(Collection $model, $arg, $bool);

    public function image(Image $model, $arg, $bool);

    public function photoSwipe(PhotoSwipe $model, $arg, $bool);
    
    public function carousel(OwlCarousel $model, $arg, $bool);

    public function markup(Markup $model, $arg, $bool);

    public function markdown(Markdown $model, $arg, $bool);

    public function hyperTextMarkup(HyperTextMarkup $model, $arg, $bool);

    public function hypertextPreprocessor(HypertextPreprocessor $model, $arg, $bool);

    public function remote(Remote $model, $arg, $bool);

    public function link(Link $model, $arg, $bool);
}
