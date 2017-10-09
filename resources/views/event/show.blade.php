<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Meta Information -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ $pricejump->coin->name }} pricejump: from {{ $pricejump->getPriceFromReadable() }} to {{ $pricejump->getPriceToReadable() }} ({{ $pricejump->getPercentage() }}% {{ $pricejump->getPriceDirection() }}) at {{ $pricejump->created_at }}</title>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.0/Chart.bundle.js"></script>

    <!-- Fonts -->
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:300,400,600' rel='stylesheet' type='text/css'>
    <!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

</head>
<body>
    <a href="https://github.com/CoinJump/coinjump.community" class="github-corner" aria-label="View source on Github"><svg width="80" height="80" viewBox="0 0 250 250" style="fill:#151513; color:#fff; position: absolute; top: 0; border: 0; right: 0;" aria-hidden="true"><path d="M0,0 L115,115 L130,115 L142,142 L250,250 L250,0 Z"></path><path d="M128.3,109.0 C113.8,99.7 119.0,89.6 119.0,89.6 C122.0,82.7 120.5,78.6 120.5,78.6 C119.2,72.0 123.4,76.3 123.4,76.3 C127.3,80.9 125.5,87.3 125.5,87.3 C122.9,97.6 130.6,101.9 134.4,103.2" fill="currentColor" style="transform-origin: 130px 106px;" class="octo-arm"></path><path d="M115.0,115.0 C114.9,115.1 118.7,116.5 119.8,115.4 L133.7,101.6 C136.9,99.2 139.9,98.4 142.2,98.6 C133.8,88.0 127.5,74.4 143.8,58.0 C148.5,53.4 154.0,51.2 159.7,51.0 C160.3,49.4 163.2,43.6 171.4,40.1 C171.4,40.1 176.1,42.5 178.8,56.2 C183.1,58.6 187.2,61.8 190.9,65.4 C194.5,69.0 197.7,73.2 200.1,77.6 C213.8,80.2 216.3,84.9 216.3,84.9 C212.7,93.1 206.9,96.0 205.4,96.6 C205.1,102.4 203.0,107.8 198.3,112.5 C181.9,128.9 168.3,122.5 157.7,114.1 C157.9,116.9 156.7,120.9 152.7,124.9 L141.0,136.5 C139.8,137.7 141.6,141.9 141.8,141.8 Z" fill="currentColor" class="octo-body"></path></svg></a><style>.github-corner:hover .octo-arm{animation:octocat-wave 560ms ease-in-out}@keyframes octocat-wave{0%,100%{transform:rotate(0)}20%,60%{transform:rotate(-25deg)}40%,80%{transform:rotate(10deg)}}@media (max-width:500px){.github-corner:hover .octo-arm{animation:none}.github-corner .octo-arm{animation:octocat-wave 560ms ease-in-out}}</style>

    <div class="container">
      <div class="header clearfix">
        <nav>
          <ul class="nav nav-pills pull-right">
              <!-- One day, we can add a login/register here?
              <li role="presentation" class="active"><a href="/login">Login</a></li>
              <li role="presentation"><a href="/register">Register</a></li>
            -->
          </ul>
        </nav>
        <h3 class="text-muted"><a href="/">CoinJump</a></h3>
      </div>

      <div class="row">
          <h2>
            {{ $pricejump->coin->long_name }} (${{ $pricejump->coin->name }}): {{ $pricejump->getPercentage() }}% {{ $pricejump->getPriceDirection() }} in {{ $pricejump->timeframe }} hours
          </h2>

          <h3>
            From {{ $pricejump->getPriceFromReadable() }} to {{ $pricejump->getPriceToReadable() }} at {{ $pricejump->created_at }} UTC
          </h2>

          @include('includes.chart', [
            'pricevalues'=> $pricevalues,
            'label' => $pricejump->coin->name . ' to '. $pricejump->currency->name,
          ])
      </div>

      <div class="row">
          <hr />
      </div>

      <div class="row">
          <div class="col-md-10 col-md-offset-1">
              <h2>Discussion on this {{ $pricejump->getPercentage() }}% pricejump</h2>
              <hr />
              <div id="disqus_thread"></div>

              <script>
                var disqus_config = function () {
                    this.page.url = "{{ $pricejump->getPermalink() }}";
                    this.page.identifier = "{{ $pricejump->getPermaidentifier() }}";
                };

                (function() { // DON'T EDIT BELOW THIS LINE
                var d = document, s = d.createElement('script');
                s.src = 'https://coinjump.disqus.com/embed.js';
                s.setAttribute('data-timestamp', +new Date());
                (d.head || d.body).appendChild(s);
                })();
              </script>

              <noscript>
                Please enable JavaScript to view the <a href="https://disqus.com/?ref_noscript">comments powered by Disqus.</a>
              </noscript>

              <em>We are currently using Disqus as a comment-platform. Ideally, we remove it and implement our own, tailored, solution on CoinJump. Want to help out? <a href="https://github.com/CoinJump">The source code is available on GitHub</a>!
          </div>
      </div>

      <footer class="footer">
          <hr />
          <p class="text-center">Provided to you by <a href="https://ma.ttias.be">Mattias Geniar</a> - <a href="https://twitter.com/mattiasgeniar">@mattiasgeniar</a></p>
      </footer>

    </div> <!-- /container -->

    <!-- Global Site Tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-107691368-1"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());

      gtag('config', 'UA-107691368-1');
    </script>
</body>
</html>
