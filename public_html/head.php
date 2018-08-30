<!DOCTYPE html>
<html>
  <head>
    <title><?php echo $heading; ?></title>
    <link rel="stylesheet" href="desktop.css"/>
    <link rel="icon" href="favicon.ico" type="image/ico" sizes="16x16">
    <meta name="viewport" content="width=device-width, initial-scale=1" />
  </head>

  <body id="clicked">
    <header>
      <div class="logo">
        <a href="index.php"> <img class="ITCLogo" src="ITC.png" alt="ITC Logo" height="135" width="240"></a>
      </div>

      <div class="navigation">
  			<ul class="nav">
  				<li><a href="index.php">Home</a></li>
          <?php echo $admin; ?></a></li>
  			</ul>
      </div>

      <div class="login">
        <ul class="nav">
          <li><?php echo $logstat; ?></li>
  			</ul>
      </div>
    </header>

    <main>
      <div class="content">
