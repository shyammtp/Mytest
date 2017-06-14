<html>
    <head>
        <title><?php echo __('Access Denied');?></title>
        <style>
            body {background-color: rgb(243, 243, 243); font-family:'arial';}
            .container {width:50%; margin: 0 auto; position: relative; top:20%;}
            .container h1{ font-size:20px; color:#333; font-family:'arial'; font-weight:normal;}
            .container p{ font-size:14px; }
            .btn-magenta {color: rgb(255, 255, 255);background-color: rgb(75, 56, 76);border-color: rgb(75, 56, 76);}
            .btn-magenta:hover {color: rgb(255, 255, 255);background-color: rgb(255, 106, 57);border-color: rgb(255, 106, 57);}
            .btn {   -moz-border-radius: 3px;   -webkit-border-radius: 3px;   border-radius: 3px;   line-height: 21px;   -moz-transition: all 0.2s ease-out 0s;  -webkit-transition: all 0.2s ease-out 0s;   transition: all 0.2s ease-out 0s;   padding: 8px 15px;   border-width: 0;}
            .btn {display: inline-block;padding: 6px 12px;margin-bottom: 0;font-size: 14px;font-weight: 400;line-height: 1.42857143;text-align: center;white-space: nowrap;vertical-align: middle;cursor: pointer;-webkit-user-select: none;-moz-user-select: none;-ms-user-select: none;user-select: none;background-image: none;border: 1px solid rgba(0, 0, 0, 0);border-radius: 4px;}.btn:focus {	outline: none;}
        </style>
    </head>
    <body>
        <div class="container">
            <div class="icon"><img src="<?php echo $this->getAssetsPathUrl('images/error/sadface.png');?>" width="64" /></div>
            <h1><?php echo __('Your Subscription has been expired');?></h1>
            <p><?php echo __("Contact Administrator for further details..");?></p> 
        </div>

    </body>
</html>