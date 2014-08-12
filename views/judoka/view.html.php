
<h1>
            <?php 
            echo $Judoka->DisplayName; 
            ?>
</h1>
<ul>
    <li>Name: <?php echo $Judoka->GivenName .' '. $Judoka->FamilyName; ?></li>
    <li>Email: <?php echo $Judoka->Email; ?></li>
   

</ul>
<p>UUID: <?php echo $Judoka->uuid; ?></p>