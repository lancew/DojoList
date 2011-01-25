<body onload="initialize()">


 <span class="fn n">
<h1>
            <?php 
            if($Dojo->DojoLogo) {
            echo '<span style="float:right;"><img alt="'.$Dojo->DojoName.'" src="'.$Dojo->DojoLogo.'" border="1px" /></span>';
            }
            echo $Dojo->DojoName; 
            ?>
</h1>
<table>
    <tr>
        <td>
            Address:
        </td>
        <td>
            <?php echo $Dojo->DojoAddress; ?>
        </td>
    </tr>
    <tr>
        <td>
            Contact:
        </td>
        <td>
            <?php echo $Dojo->ContactName; ?>
        </td>
    </tr>    
    <tr>
        <td>
            Telephone:
        </td>
        <td>
            <?php
            if ($Dojo->ContactPhone) {
		          print"<a href='callto:$Dojo->ContactPhone'>$Dojo->ContactPhone</a>";
		    }
            ?>
        </td>
    </tr> 
    <tr>
        <td>
            email:
        </td>
        <td>
            <?php 
            if ($Dojo->ContactEmail) {
		          print"<a href='mailto:$Dojo->ContactEmail'>$Dojo->ContactEmail</a>";
		    }

            
             ?>
        </td>
    </tr>     
    <tr>
        <td>
            Website:
        </td>
        <td>
            <?php 
        	if ($Dojo->ClubWebsite) {
		      print "<a href='http://$Dojo->ClubWebsite'>$Dojo->ClubWebsite</a>";
		     
		    }

            
             ?>
        </td>
    </tr> 
    <tr>
    <td>
        National Governing Body ID #
    </td>
    <td>
        <?php echo $Dojo->MembershipID; ?>
    </td>
    </tr>
    <tr></tr>
    <tr>
        <td>
            Head Coach:
        </td>
        <td>
            <?php 
        	if ($Dojo->CoachName) {
		      print "$Dojo->CoachName";
		      		     
		    }

            
             ?>
        </td>
    </tr> 
    <tr>
    <td></td>
    <td>
        <?php
        if($Dojo->CoachPhoto){
        echo '<span style="float:left;"><img alt="'.$Dojo->CoachPhoto.'" src="'.$Dojo->CoachPhoto.'" border="1px" /></span>';
        }
        ?>
    </td>
    </tr>    





    <tr>
    <td>Map of Dojo Location:</td>
    <td>
    
    <div id="mapstraction"></div>
    <script src="http://maps.google.com/maps?file=api&v=2&key=<?php echo option('GoogleKey') ?>" type="text/javascript">
    </script>
    <script type="text/javascript" src="/<?php echo option('js_dir') ?>/mapstraction.js">
    </script>
    <style type="text/css">
        #mapstraction {
            height: 250px;
            width: 250px;
        }
    </style>

    <script type="text/javascript">
      // initialise the map with your choice of API
        var mapstraction = new Mapstraction('mapstraction','openstreetmap');

        var myPoint = new LatLonPoint(<?php echo $Dojo->Latitude.','.$Dojo->Longitude; ?>);
        // display the map centered on a latitude and longitude (Google zoom levels)
        mapstraction.setCenterAndZoom(myPoint, 9);
        mapstraction.addControls({zoom: 'small'});

        mapstraction.setCenterAndZoom(myPoint, 12);

        // create a marker positioned at a lat/lon
        var marker = new Marker(myPoint);

        // display marker
	    mapstraction.addMarker(marker);



    </script>
    </td>
    </tr>

    
       <tr>
    <td><h3>Training Sessions</h3></td>
    <td></td>
    </tr> 
    
    
    <tr>
    <td></td>
    <td>
        <?php
        
        
          
                    if($Dojo->TrainingSession1Day)
                        {
                        echo '<tr><td></td><td>';
                        echo "$Dojo->TrainingSession1Day".", "
                            ."$Dojo->TrainingSession1Time".", "
                            ."$Dojo->TrainingSession1Age";
                        
                        }
                    if($Dojo->TrainingSession2Day)
                        {
                        echo '<tr><td></td><td>';
                        echo "$Dojo->TrainingSession2Day".", "
                            ."$Dojo->TrainingSession2Time".", "
                            ."$Dojo->TrainingSession2Age";
                        
                        }
                     if($Dojo->TrainingSession3Day)
                        {
                        echo '<tr><td></td><td>';
                        echo "$Dojo->TrainingSession3Day".", "
                            ."$Dojo->TrainingSession3Time".", "
                            ."$Dojo->TrainingSession3Age";
                        
                        }
                      if($Dojo->TrainingSession4Day)
                        {
                        echo '<tr><td></td><td>';
                        echo "$Dojo->TrainingSession4Day".", "
                            ."$Dojo->TrainingSession4Time".", "
                            ."$Dojo->TrainingSession4Age";
                        
                        }
                     if($Dojo->TrainingSession5Day)
                        {
                        echo '<tr><td></td><td>';
                        echo "$Dojo->TrainingSession5Day".", "
                            ."$Dojo->TrainingSession5Time".", "
                            ."$Dojo->TrainingSession5Age";
                        
                        }
                      if($Dojo->TrainingSession6Day)
                        {
                        echo '<tr><td></td><td>';
                        echo "$Dojo->TrainingSession6Day".", "
                            ."$Dojo->TrainingSession6Time".", "
                            ."$Dojo->TrainingSession6Age";
                        
                        }   
                      if($Dojo->TrainingSession7Day)
                        {
                        echo '<tr><td></td><td>';
                        echo "$Dojo->TrainingSession7Day".", "
                            ."$Dojo->TrainingSession7Time".", "
                            ."$Dojo->TrainingSession7Age";
                        
                        }   
                      if($Dojo->TrainingSession8Day)
                        {
                        echo '<tr><td></td><td>';
                        echo "$Dojo->TrainingSession8Day".", "
                            ."$Dojo->TrainingSession8Time".", "
                            ."$Dojo->TrainingSession8Age";
                        
                        }    
                      if($Dojo->TrainingSession9Day)
                        {
                        echo '<tr><td></td><td>';
                        echo "$Dojo->TrainingSession9Day".", "
                            ."$Dojo->TrainingSession9Time".", "
                            ."$Dojo->TrainingSession9Age";
                        
                        }                  
                      if($Dojo->TrainingSession10Day)
                        {
                        echo '<tr><td></td><td>';
                        echo "$Dojo->TrainingSession10Day".", "
                            ."$Dojo->TrainingSession10Time".", "
                            ."$Dojo->TrainingSession10Age";
                        
                        }   
                
                
        ?>
    </td>
    </tr>
    
</table>


    
    

    <p />&nbsp;<p />
    <a href="<?php echo url_for('dojo', $Dojo->DojoName, 'edit'); ?>">
    <?php echo _("[EDIT DOJO]"); ?></a>
    - <a href="<?php echo url_for('dojo', $Dojo->DojoName, 'delete'); ?>">
    <?php echo _("[DELETE DOJO]"); ?>
    </a>
    <p>
        <?php echo "Last Updated: $Dojo->Updated."; ?>
    </p>
    <?php
        if($Dojo->GUID){
            echo "<p>Dojo ID# $Dojo->GUID<//p>";
        
        }
    ?>
    
   
   
   
   
   