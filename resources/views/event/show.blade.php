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
              {{ $pricejump->coin->name }}: from {{ $pricejump->getPriceFromReadable() }} to {{ $pricejump->getPriceToReadable() }} ({{ $pricejump->getPercentage() }}% {{ $pricejump->getPriceDirection() }}) at {{ $pricejump->created_at }} UTC
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
</body>
</html>
