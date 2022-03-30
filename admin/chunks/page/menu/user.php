<?php /** @noinspection PhpUnhandledExceptionInspection */
    namespace xbweb;
    $username = User::current()->data['login'];
    if (empty($username)) $username = 'Anonimous';
?>
<nav class="user-menu">
    <a class="username" href="#"><?=$username?></a>
    <a class="avatar" href="#"></a>
    <ul>
        <li class="category-info">
            <a class="avatar" href="#"></a>
            <span class="info">
        <span class="username"><?=$username?></span>
        <?=View::menu('userprofile', array(
            'item' => '<a class="button" href="[+url+]">[+title+][+counter+]</a>'
        ))?>
        </span>
        </li>
        <?=View::menu('user', array(
            'block'    => '<ul>[+items+]</ul>',
            'category' => '<li class="category"><ul>[+items+]</ul></li>',
            'item'     => '<li class="menu-item-[+key+]"><a href="[+url+]">[+title+][+counter+]</a></li>'
        ))?>
    </ul>
</nav>