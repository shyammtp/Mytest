<html>
    <head>
        <title><?php echo __('404 Not Found');?></title>
		<style>
			.page_404{display:inline-block;width:100%;text-align:center;vertical-align:middle;width:100%;margin-top:60px;}
			.page_404 p{font-size:30px;font-family:Verdana,arial;}
			.page_404 p span{color:#1896D0;margin-right:6px;}
			.page_404 img{max-width:100%;}
			.btn-default4:hover{background:#f2f2f2;}
			.btn-default4{background: #f4f4f4; /* Old browsers */
			background: -moz-linear-gradient(top, #ffffff 0%, #fcfcfc 26%, #f9f9f9 52%, #f9f9f9 77%, #f4f4f4 100%, #f3f3f3 100%); 
			background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#ffffff), color-stop(26%,#fcfcfc), color-stop(52%,#f9f9f9), color-stop(77%,#f9f9f9), color-stop(100%,#f4f4f4), color-stop(100%,#f3f3f3));
			background: -webkit-linear-gradient(top, #ffffff 0%,#fcfcfc 26%,#f9f9f9 52%,#f9f9f9 77%,#f4f4f4 100%,#f3f3f3 100%); 
			background: -o-linear-gradient(top, #ffffff 0%,#fcfcfc 26%,#f9f9f9 52%,#f9f9f9 77%,#f4f4f4 100%,#f3f3f3 100%); 
			background: -ms-linear-gradient(top, #ffffff 0%,#fcfcfc 26%,#f9f9f9 52%,#f9f9f9 77%,#f4f4f4 100%,#f3f3f3 100%);
			background: linear-gradient(to bottom, #ffffff 0%,#fcfcfc 26%,#f9f9f9 52%,#f9f9f9 77%,#f4f4f4 100%,#f3f3f3 100%);
			font-size:16px;color:#1896D0;font-family:Verdana,arial;border:solid 1px #dadada;border-radius:4px;padding:7px 0;width:200px; text-align:center;display:inline-block;cursor:pointer;}
			@media screen and (max-width:600px) {
			.page_404 p{font-size:18px;}
			}
		</style>
    </head>
    <body>
        <div class="container">
		   <div class="page_404">
            <div class="img_404">
				<img src="<?php echo $this->getAssetsPathUrl('images/404page.jpg');?>" />
			</div>
            <?php /* echo $this->getMessage();*/ ?>
			<p><span>Sorry!</span> The page you’re looking for cannot be found.</p>
            <div class="btn-group">
                <a onclick="javascript:history.go(-1);" class="btn btn-default4"><span><&nbsp;&nbsp;&nbsp;</span><?php echo __("Go Back");?></a>
            </div>
        </div>
        </div>

    </body>
</html>