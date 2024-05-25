@php 
use App\Models\frontend\Maintainance;

$maintainance_image = Maintainance::first();
@endphp

<!doctype html>
<html>
<title>Site Maintenance</title>
<head>
<link rel="stylesheet" type="text/css" href="{{ asset('public/backend-assets/css/bootstrap.min.css') }}">
<style>
  /* body { text-align: center; padding: 150px; }
  h1 { font-size: 50px; }
  body { font: 20px Helvetica, sans-serif; color: #333; }
  article { display: block; text-align: left; width: 650px; margin: 0 auto; }
  a { color: #dc8100; text-decoration: none; }
  a:hover { color: #333; text-decoration: none; } */
</style>
</head>


<!-- <article>
    <h1>We&rsquo;ll be back soon!</h1>
    <div>
        <p>Sorry for the inconvenience but we&rsquo;re performing some maintenance at the moment. If you need to you can always <a href="mailto:#">contact us</a>, otherwise we&rsquo;ll be back online shortly!</p>
        <p>&mdash; The Team</p>
    </div>
</article> -->
<body >
    <div style="height: 100vh;overflow: hidden;">
        <img class="img-fluid" style="object-fit: contain;object-position: center;width: 100%;height: 100%;" src="{{asset('public/frontend-assets/images')}}/{{ (isset($maintainance_image) && ($maintainance_image->maintainance_image != ''))?$maintainance_image->maintainance_image:'Maintenance-page-image.jpg' }}">
    </div>
</body>
</html>