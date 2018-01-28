<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    Plugin_Name
 * @subpackage Plugin_Name/admin/partials
 */
?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->
<div class="wrap">
    <h1>ARCHE Augsburg Communication Plugin</h1>
    <h2 class="nav-tab-wrapper">
        <?php 
            foreach( $tabs as $tab => $name )
            {
                $class = ( $tab == $current ) ? ' nav-tab-active' : '';
                echo "<a class='nav-tab$class' href='?page=aacp-settings&tab=$tab'>$name</a>";
            }
        ?>
    </h2>
</div>