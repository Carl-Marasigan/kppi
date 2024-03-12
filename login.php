<!DOCTYPE html>
<html lang="en">
  <style>
  canvas {
  
  position: absolute;
  top: 0;
  left: 0;
  background-color: black;
}
    </style>
<head>
  <meta charset="UTF-8">
  <title>Customer Requirements Integration System</title>
  <link rel="shortcut icon" href="assets/dist/img/kp1.png">
  <link rel="stylesheet" href="./style.css">
  <!-- <link rel="stylesheet" href="css/style.css" /> -->
</head>
<body>
<canvas id=c></canvas>
<!-- <div class="loader">
      <div class="name">

      </div>
      <span style="--i: 1"></span>
      <span style="--i: 2"></span>
      <span style="--i: 3"></span>
      <span style="--i: 4"></span>
      <span style="--i: 5"></span>
      <span style="--i: 6"></span>
      <span style="--i: 7"></span>
      <span style="--i: 8"></span>
      <span style="--i: 9"></span>
      <span style="--i: 10"></span>
    </div> -->
  <div class="box">
    <div class="form">
      
      <img src="assets/dist/img/cris-new.png" alt="" style="display: flex; margin: auto;" width="250" height="80">
      <!-- <h2>CRIS LOGIN</h2> -->
      
      <?php
        session_start();

        

        if(isset($_POST['login'])) {
          // Establish a connection to the database
          include 'connection_string/connect-db.php';

          // Retrieve the input values from the form
          $username = $_POST['username'];
          $password = md5($_POST['password']);

          // Query the database to check if the input values match a record in the table
          $sql = "SELECT * FROM cis_users_accounts WHERE username='$username' AND password='$password'";
          $result = mysqli_query($conn, $sql);

          // If the query returns a matching record, set session variables with the user ID, username, and password
          if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['username'] = $row['username'];
            $_SESSION['password'] = $row['password'];
            $_SESSION['department'] = $row['department'];
            $_SESSION['role'] = $row['role'];
            $_SESSION['emp'] = $row['emp'];
            $_SESSION['img'] = $row['img'];

            // Check the user's department and redirect them accordingly
            switch ($_SESSION['department']) {
              case 1:
                header("Location: cris_dashboard.php");
                exit;
                break;
              case 2:
                header("Location: cris_dashboard.php");
                // header("Location: mpd/cris_mpd_dashboard.php");
                exit;
                break;
              case 3:
                header("Location: cris_dashboard.php");
                exit;
                break;
              case 4:
                header("Location: cris_dashboard.php");
                exit;
                break;
              default:
                header("Location: index.php");
                exit;
                break;
            }

          } else {
            // If the query does not return a matching record, display an error message
            echo "<p style='color:red; text-align:center;'>Invalid username or password.</p>";
          }

          // Close the database connection
          mysqli_close($conn);
        }
      ?>

      <form action="login.php" method="POST">
        <div class="inputBox">
          <input type="text" name="username" required>
          <span>Username</span>
          <i></i>
        </div>
        <div class="inputBox">
          <input type="password" name="password" required>
          <span>Password</span>
        <i></i>
      </div>
      <input type="submit" name="login" value="Login" class="login-btn">
    </form>
  </div>
</div>
</div>
</body>

<script>
  var w = c.width = window.innerWidth,
    h = c.height = window.innerHeight,
    ctx = c.getContext( '2d' ),
    
    minDist = 10,
    maxDist = 30,
    initialWidth = 10,
    maxLines = 100,
    initialLines = 4,
    speed = 5,
    
    lines = [],
    frame = 0,
    timeSinceLast = 0,
    
    dirs = [
   // straight x, y velocity
      [ 0, 1 ],
      [ 1, 0 ],
      [ 0, -1 ],
    	[ -1, 0 ],
   // diagonals, 0.7 = sin(PI/4) = cos(PI/4)
      [ .7, .7 ],
      [ .7, -.7 ],
      [ -.7, .7 ],
      [ -.7, -.7]
    ],
    starter = { // starting parent line, gagamit ako pseudocode
      
      x: w / 2,
      y: h / 2,
      vx: 0,
      vy: 0,
      width: initialWidth
    };

function init() {
  
  lines.length = 0;
  
  for( var i = 0; i < initialLines; ++i )
    lines.push( new Line( starter ) );
  
  ctx.fillStyle = '#222';
  ctx.fillRect( 0, 0, w, h );
  

  // ctx.lineCap = 'round';
}
function getColor( x ) {
  
  return 'hsl( hue, 80%, 50% )'.replace(
  	'hue', x / w * 360 + frame
  );
}
function anim() {
  
  window.requestAnimationFrame( anim );
  
  ++frame;
  
  ctx.shadowBlur = 0;
  ctx.fillStyle = 'rgba(0,0,0,.02)';
  ctx.fillRect( 0, 0, w, h );
  ctx.shadowBlur = .5;
  
  for( var i = 0; i < lines.length; ++i ) 
    
    if( lines[ i ].step() ) { // if true it's dead
      
      lines.splice( i, 1 );
      --i;
      
    }
  
  // spawn new
  
  ++timeSinceLast
  
  if( lines.length < maxLines && timeSinceLast > 10 && Math.random() < .5 ) {
    
    timeSinceLast = 0;
    
    lines.push( new Line( starter ) );
    
    // cover the middle;
    ctx.fillStyle = ctx.shadowColor = getColor( starter.x );
    ctx.beginPath();
    ctx.arc( starter.x, starter.y, initialWidth, 0, Math.PI * 2 );
    ctx.fill();
  }
}

function Line( parent ) {
  
  this.x = parent.x | 0;
  this.y = parent.y | 0;
  this.width = parent.width / 1.25;
  
  do {
    
    var dir = dirs[ ( Math.random() * dirs.length ) |0 ];
    this.vx = dir[ 0 ];
    this.vy = dir[ 1 ];
    
  } while ( 
    ( this.vx === -parent.vx && this.vy === -parent.vy ) || ( this.vx === parent.vx && this.vy === parent.vy) );
  
  this.vx *= speed;
  this.vy *= speed;
  
  this.dist = ( Math.random() * ( maxDist - minDist ) + minDist );
  
}
Line.prototype.step = function() {
  
  var dead = false;
  
  var prevX = this.x,
      prevY = this.y;
  
  this.x += this.vx;
  this.y += this.vy;
  
  --this.dist;
  
  // kill if out of screen
  if( this.x < 0 || this.x > w || this.y < 0 || this.y > h )
    dead = true;
  
  // make children :D
  if( this.dist <= 0 && this.width > 1 ) {
    
    // keep yo self, sometimes
    this.dist = Math.random() * ( maxDist - minDist ) + minDist;
    
    // add 2 children
    if( lines.length < maxLines ) lines.push( new Line( this ) );
    if( lines.length < maxLines && Math.random() < .5 ) lines.push( new Line( this ) );
    
    // kill the poor thing
    if( Math.random() < .2 ) dead = true;
  }
  
  ctx.strokeStyle = ctx.shadowColor = getColor( this.x );
  ctx.beginPath();
  ctx.lineWidth = this.width;
  ctx.moveTo( this.x, this.y );
  ctx.lineTo( prevX, prevY );
  ctx.stroke();
  
  if( dead ) return true
}

init();
anim();

window.addEventListener( 'resize', function() {
  
  w = c.width = window.innerWidth;
  h = c.height = window.innerHeight;
  starter.x = w / 2;
  starter.y = h / 2;
  
  init();
} )
  </script>
</html>

