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
    <div class="nav-tab-wrapper">
        <a class="nav-tab nav-tab-ical-sync nav-tab-active" href="#ical-sync">Ical Sync</a>
        <a class="nav-tab nav-tab-file-exports" href="#file-exports">Dateiexporte</a>
        <a class="nav-tab nav-tab-podcast-file-validation" href="#podcast-file-validation">Podcast Dateien</a>
        <a class="nav-tab nav-tab-online-newsletter" href="#online-newsletter">Online Newsletter</a>
    </div>
    <div class="tab-ical-sync">
        <h3>ChurchTools Kalender .ics export</h3>
        <p>Die Kalender in ChurchTools werden stündlich exportiert.</p>
        <div class="export-status">
            <?php 
                $synchronizer = new aacp_IcalSynchronizer();
                echo $synchronizer->evaluate_log_file();
            ?>
        </div>
        <h3>Einlesen der .ics exporte auf der Homepage</h3>
        <p>Die Homepage liest die exportierten Dateien alle 24 Stunden neu ein und gibt ihnen diese kryptischen Namen.</p>
        <div class="cache-status">
            <?php
                echo $synchronizer->evaluate_cache_files();
            ?>
        </div>
        <h3>Manuelle Synchronisation</h3>
        <p>Hier kann die Synchronisation (sowohl der Export, als auch das Einlesen auf der Homepage) manuell ausgeführt werden.</p>
        <input type="submit" name="submit" id="synchronize-calendar" class="button button-primary" value="Jetzt synchronisieren">
    </div>
    <div class="tab-file-exports hidden">
        <h3>ARCHE Termine (Print-Newsletter)</h3>
        <p>Der ARCHE-Termine Print-Newsletter erscheint einmal monatlich jeweils Mitte des Vormonats. 
        Ab dem 15. eines Monats kann die Vorlage hier exportiert werden.</p>
        <p>Damit ein Event berücksichtigt wird, muss das Startdatum eines Events im jeweiligen Monat liegen und die Anzeigeeinstellung "ARCHE-Termine print" aktiviert sein.<p>
            <?php
                $file_export_manager = new aacp_FileExportManager();
                $month_of_export = $file_export_manager->get_month_of_export_newsletter();
                $events = $file_export_manager->query_events_for_selection();
            ?>
        <form id="nl-export-form" method="post">
            <fieldset>
            <input type="hidden" name="action" value="newsletterexport"> 
            <input type="hidden" name="month" value="<?php echo $month_of_export['number']; ?>">    
                <ul>
                    <?php foreach ($events as $event) { ?>
                    <li>
                        <label>
                            <input type="checkbox" name="post_ids[]" value="<?php echo $event['post_id']; ?>">
                            <?php echo $event['post_title']; ?>
                        </label>
                    </li>
                    <?php } ?> 
                </ul> 
            </fieldset>
            <input type="submit" name="submit" id="export-print-newsletter" class="button button-primary" value="Vorlage <?php echo $month_of_export['word']?> herunterladen">
        </form>   
         <div class="export-print-newsletter-response"></div>
    </div>
    <div class="tab-podcast-file-validation hidden">
        <p>Die Podcast Dateien werden wöchentlich validiert und einen Email versandt, wenn falsch benannte 
        Dateien entdeckt werden. Fehlerhaft benannte Dateien werden auf der Homepage nicht angezeigt.</p>
        <p>Status: 
            <?php
                $file_validator = new aacp_FileValidator();
                echo $file_validator->get_configuration_status();
            ?>
        </p>
        <p>Hier werden momentan fehlerhaft benannte Dateien anzezeigt.</p>
        <div class="">
            <?php
                echo $file_validator->validate_and_get_bad_files();
            ?>
        </div>
    </div>
    <div class="tab-online-newsletter hidden">
        <p>Wenn die Zugangsdaten in der config Datei eingetragen sind, wird die erste Grafikdatei eines Events automatisch
        mit dem click auf "veröffentlichen" in die Mailchimp Mediathek hochgeladen.</p>
        <p>Status: 
            <?php
                $mailchimp_intrgration = new aacp_MailchimpIntegration();
                echo $mailchimp_intrgration->get_mailchimp_integration_status();
            ?>
        </p>
    </div>
</div>