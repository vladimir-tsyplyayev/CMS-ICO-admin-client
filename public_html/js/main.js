var canvas = document.querySelector("canvas");
canvas.width = window.innerWidth;
canvas.height = window.innerHeight;
var ctx = canvas.getContext("2d");

var TAU = 2 * Math.PI;

times = [];
function loop() {
  var startTime = performance .now();
  ctx.clearRect(0, 0, canvas.width, canvas.height);
  update();
  draw();
  times.push(performance.now() - startTime);
  if (times.length > 500) {
    times.shift()
  }
  requestAnimationFrame(loop);
}

function Ball (startX, startY, startVelX, startVelY) {
  this.x = startX || Math.random() * canvas.width;
  this.y = startY || Math.random() * canvas.height;
  this.vel = {
    x: startVelX || Math.random() * 2 - 1,
    y: startVelY || Math.random() * 2 - 1
  };
  this.update = function(canvas) {
    if (this.x > canvas.width + 50 || this.x < -50) {
      this.vel.x = -this.vel.x;
    }
    if (this.y > canvas.height + 50 || this.y < -50) {
      this.vel.y = -this.vel.y;
    }
    this.x += this.vel.x;
    this.y += this.vel.y;
  };
  this.draw = function(ctx, can) {
    ctx.beginPath();
    if (distMouse(this) > 100) {
      ctx.fillStyle = "#fff";
      ctx.globalAlpha =  .1;
    } else {
        ctx.fillStyle = '#fff';
      ctx.globalAlpha =  .3;
    }
    ctx.arc((0.5 + this.x) | 0, (0.5 + this.y) | 0, 1, 0, TAU, false);
    ctx.fill();
  }
}

var balls = [];
for (var i = 0; i < canvas.width * canvas.height / (65*65); i++) {
  balls.push(new Ball(Math.random() * canvas.width, Math.random() * canvas.height));
}

var lastTime = Date.now();
function update() {
  var diff = Date.now() - lastTime;
  for (var frame = 0; frame * 36.6667 < diff; frame++) {
    for (var index = 0; index < balls.length; index++) {
      balls[index].update(canvas);
    }
  }
  lastTime = Date.now();
}
var mouseX = -1e9, mouseY = -1e9;
document.addEventListener('mousemove', function(event) {
  mouseX = event.clientX;
  mouseY = event.clientY;
});

function distMouse(ball) {
  return Math.hypot(ball.x - mouseX, ball.y - mouseY);
}

function draw() {
  for (var index = 0; index < balls.length; index++) {
    var ball = balls[index];
    ball.draw(ctx, canvas);
    ctx.beginPath();
    for (var index2 = balls.length - 1; index2 > index; index2 += -1) {
      var ball2 = balls[index2];
    var dist = Math.hypot(ball.x - ball2.x, ball.y - ball2.y);
        if (dist < 100) {
          if (distMouse(ball) > 100) {
            ctx.strokeStyle = "#fff";
            ctx.globalAlpha = .1;
          } else {
            ctx.strokeStyle = '#fff';
            ctx.globalAlpha =  .3;
          }
          ctx.lineWidth = "1px";
          ctx.moveTo((0.5 + ball.x) | 0, (0.5 + ball.y) | 0);
          ctx.lineTo((0.5 + ball2.x) | 0, (0.5 + ball2.y) | 0);
        }
}
    ctx.stroke();
  }
}

// Start
loop();







$(".faq p").hide();
$(".faq b").click(function () {
    $(this).next(".faq p").slideToggle(500);
    $(this).toggleClass("expanded");
});

$(".navbar_block").hide();
$(".navbar i").click(function () {
    $(".navbar_block").slideToggle(500);
    $("#blackbg").toggleClass("active");
});



//$(".profile_nav").hide();
$(".navbar_panel i").click(function () {
    $(".profile_nav").slideToggle(500);
});

$(".profile_nav_item").click(function () {
  $(".profile_nav").slideToggle(500);
  });


$("#blackbg").click(function () {
    $(this).css('display','none');
    if($("#signin").is(':visible')){
      $('#signin').css('display','none');
    }
    if($("#alert").is(':visible')){
      $('#alert').css('display','none');
    }
    if($("#user_panel").is(':visible')){
      $('#user_panel').css('display','none');
    }
    if($(".navbar_block").is(':visible')){
      $(".navbar_block").slideToggle(500);
      $(".navbar i").toggleClass("expanded");
      $("#blackbg").toggleClass("active");
    }
});




$("[id^=nav_item_]").on('click mouseover', function () {
    var id = this.id.match(/\d+/);
    $(".profile_content_item").removeClass("active");
    $(".profile_head").removeClass("active");
    $(".content_item_"+id).toggleClass("active");
});



/*
window.onload = function() {
  $("#g-recaptcha-response").attr("required", true);
}
*/

function changeform(a){
  if(a==0) change_form(0,1,1);
  if(a==1) change_form(1,0,1);
  if(a==2) change_form(1,1,0);
}


function change_form(a,b,c){

  $('.email').css('display','block');
  $('.input').css('display','block');
  $('.email input').attr('required', true);
  $('.input').attr('required', true);
  $("#g-recaptcha-response").attr("required", true);

  if(a==0){
    $('.register_form').css('display','block');
    $(".register_form input").attr("required", true);
    $('#register_form').css('display','none');
  }else{
    $('.register_form').css('display','none');
    $(".register_form input").removeAttr('required');
  }

  if(b==0){
    $('.signin_form').css('display','block');
    $('#signin_form').css('display','none');
  }else{
    $('.signin_form').css('display','none');
  }

  if(c==0){
    $('.forgot_form').css('display','block');
    $("#pass_form input").removeAttr('required');
    $("#pass_form").css('display','none');
    $('#register_form').css('display','block');
    $('#signin_form').css('display','block');
    $('#forgot_form').css('display','none');
  }else{
    $('.forgot_form').css('display','none');
    $("#pass_form input").attr("required", true);
    $("#pass_form").css('display','block');
    $('#forgot_form').css('display','block');
  }

  $('.forgot_form_new_pass').css('display','none');

}






$(document).ready(function(){

  //var d=new Date(1518084000000);
  
  if (window.d !== undefined) {

    var month=(window.d.getMonth()+1);
    month=month<10?'0'+month:month;
    var day=window.d.getDate();
    day=day<10?'0'+day:day;
    var hours=window.d.getHours();
    hours=hours<10?'0'+hours:hours;
    var minutes=window.d.getMinutes();
    minutes=minutes<10?'0'+minutes:minutes;
    $('#countdown').countdown(d.getFullYear()+'/'+month+'/'+day+' '+hours+':'+minutes+':00', function (event) {
        $(this).html(event.strftime('<ul><li>%D <span>days</span></li><li>%H <span>Hours</span></li><li>%M <span>minutes</span></li><li>%S <Span>seconds</Span></li></ul>'));
    });
  }
    
    //Check to see if the window is top if not then display button
    $(window).scroll(function(){
        if ($(this).scrollTop() > 100) {
            $(".scrollToTop").fadeIn();
        } else {
            $(".scrollToTop").fadeOut();
        }
    });
    
    //Click event to scroll to top
    $(".scrollToTop").click(function(){
        $("html, body").animate({scrollTop : 0},800);
        return false;
    });
    
});












!function(e,t,n,s,u,a){e.twq||(s=e.twq=function(){s.exe?s.exe.apply(s,arguments):s.queue.push(arguments);
},s.version='1.1',s.queue=[],u=t.createElement(n),u.async=!0,u.src='//static.ads-twitter.com/uwt.js',
a=t.getElementsByTagName(n)[0],a.parentNode.insertBefore(u,a))}(window,document,'script');
// Insert Twitter Pixel ID and Standard Event data below
twq('init','nz34c');
twq('track','PageView');





















