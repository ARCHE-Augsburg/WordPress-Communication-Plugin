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
        <a class="nav-tab nav-tab-ical-sync nav-tab-active" href="#ical-sync">Ical Sync</a>
        <a class="nav-tab nav-tab-file-exports" href="#file-exports">Dateiexporte</a>
        <a class="nav-tab nav-tab-podcast-file-validation" href="#podcast-file-validation">Podcast Dateien</a>
    </h2>
    <div class="tab-ical-sync">
        <h2>Ical-Synchronisation</h2>
        <h3>ChurchTools Kalender .ics export</h3>
        <p>Die Kalender in ChurchTools werden stündlich exportiert.</p>
        <div class="export-status">
            <?php 
                $synchronizer = new aacp_IcalSynchronizer();
                echo $synchronizer->evaluateLogFile();
            ?>
        </div>
        <h3>Einlesen der .ics exporte auf der Homepage</h3>
        <p>Die Homepage liest die exportierten Dateien alle 24 Stunden neu ein.</p>
        <div class="cache-status">
            <?php 
                $synchronizer = new aacp_IcalSynchronizer();
                echo $synchronizer->evaluateCacheFiles();
            ?>
        </div>
        <h3>Manuelle Synchronisation</h3>
        <p>Hier kann die Synchronisation (erst der Export, dann das Einlesen auf der Homepage) manuell ausgeführt werden.</p>
        <input type="submit" name="submit" id="synchronize-calendar" class="button button-primary" value="Jetzt synchronisieren">
    </div>
    <div class="tab-file-exports hidden">
        <h2>Dateiexporte</h2>
        <p>Hier kannst du die Exporteinstellungen für verschiedene Dateien festlegen und manuell exportieren.</p>
        
        <h3>ARCHE Termine (Print-Newsletter)</h3>
        <p>Der ARCHE-Termine Print-Newsletter erscheint einmal monatlich jeweils Mitte des Vormonats.<p>
        
        <input type="submit" name="submit" id="export-print-newsletter" class="button button-primary" value="docx herunterladen">
        <div class="export-print-newsletter-response"></div>
        
        <h3>Powerpoint-Präsentation</h3>
        <p>Die Präsentation läuft jeden Sonntag vor den Gottesdiensten.<p>
        
        <input type="submit" name="submit" id="submit" class="button button-primary" value="ppp herunterladen">
    </div>
    <div class="tab-podcast-file-validation hidden">
        <h2>Podcast Dateien</h2>
        <p>Hier werden eventuell fehlerhaft benannte Dateien anzezeigt.</p>
        <div class="export-status">
            <?php 
                $synchronizer = new aacp_FileValidator();
                echo $synchronizer->validateAndSendEmail();
            ?>
        </div>
    </div>
</div>