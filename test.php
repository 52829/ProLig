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
<html>
<head>
<meta charset="UTF-8">
<title>PROLIG</title>

<style>
body {
  margin:0;
  background: radial-gradient(circle at top, #151515, #0b0b0b);
  font-family: Inter, sans-serif;
  color:white;
  overflow-x:hidden;
}

.tournaments-top {
  width:420px;
  margin:40px auto;
}


.t-card {
  background: rgba(255,255,255,0.05);
  border:1px solid rgba(255,255,255,0.08);
  border-radius:14px;
  margin-bottom:12px;
  overflow:hidden;
  cursor:pointer;
  transition: transform 0.25s ease, border-color 0.25s ease;
  box-shadow: 0 10px 25px rgba(0,0,0,0.35);
  will-change: transform;
}

.t-card:hover {
  transform: translateY(-3px);
  border-color: rgba(31,182,201,0.4);
}

.t-card-header {
  padding:14px;
  text-align:center;
  font-weight:700;
}

.t-card-time {
  display:inline-block;
  margin-top:6px;
  padding:4px 10px;
  font-size:12px;
  border-radius:999px;
  background: rgba(255,255,255,0.08);
  color:#cfcfcf;
  letter-spacing:0.5px;
}

.time-live {
  background:red;
  color:white;
  font-weight:700;
  animation:pulse 1.2s infinite;
}

.time-soon {
  background: rgba(31,182,201,0.25);
  color:#1fb6c9;
}

.t-card-body {
  display:grid;
  grid-template-rows: 0fr;
  transition: grid-template-rows 0.35s ease;
}

.t-card-body-inner {
  overflow:hidden;
  text-align:center;
  padding:0 12px;
}

.t-card.active .t-card-body {
  grid-template-rows: 1fr;
}

.t-card.active .t-card-body-inner {
  padding:12px;
}

.t-card img {
  width:100%;
  height:140px;
  object-fit:cover;
  border-radius:10px;
  margin-bottom:10px;
}

.btn {
  margin-top:10px;
  padding:9px 16px;
  border:none;
  border-radius:8px;
  background:#1fb6c9;
  color:white;
  font-weight:600;
  cursor:pointer;
  transition:0.2s;
}

.btn:hover {
  transform: scale(1.03);
}

.live {
  display:inline-block;
  margin-top:6px;
  padding:3px 10px;
  font-size:11px;
  border-radius:999px;
  background:red;
  font-weight:700;
  animation:pulse 1.2s infinite;
}

@keyframes pulse {
  0% { box-shadow:0 0 0 0 rgba(255,0,0,0.6); }
  70% { box-shadow:0 0 0 10px rgba(255,0,0,0); }
  100% { box-shadow:0 0 0 0 rgba(255,0,0,0); }
}
</style>
</head>

<body>

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
