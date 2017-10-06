<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Meta Information -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Crypto Price Jump Explainer</title>

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

      <div class="jumbotron">
        <h1>Crowdsourced Cryptocurrency Pricejump Explanations</h1>
        <p class="lead">
            Cryptocurrencies like Bitcoin (BTC), Litecoin (LTC) or Ethereum (ETH) can rapidly gain or lose value, without a clear reason. Here, we try to crowdsource the <em>why</em> of every price jump. Both up and down, so we can learn from them and attempt to detect them earlier.
        </p>
        <p>
            We're now tracking the {{ $coinCount }} most valuable coins.
        </p>
      </div>

      <div class="row">
          <h2>Last 24h of BTC-USD</h2>
          @include('includes.chart', [
            'pricevalues'=> $pricevalues,
            'label' => 'BTC - USD',
          ])
      </div>

      <div class="row">
          <h2>Pricejumps</h2>

          <ul>
              @foreach ($recentPriceJumps as $pricejump)

              <li>
                  <a href="{{ $pricejump->getPermalink() }}">
                      {{ $pricejump->coin->name }}: from {{ $pricejump->getPriceFromReadable() }} to {{ $pricejump->getPriceToReadable() }} ({{ $pricejump->getPercentage() }}% {{ $pricejump->getPriceDirection() }}
                  </a>
              </li>

              @endforeach
          </ul>


          <p>
              <small>A "jump" is defined as a 10% price change within the time range of 3 hours.</small>
          </p>
      </div>

      <footer class="footer">
          <hr />
          <p class="text-center">Provided to you by <a href="https://ma.ttias.be">Mattias Geniar</a> - <a href="https://twitter.com/mattiasgeniar">@mattiasgeniar</a></p>
      </footer>

    </div> <!-- /container -->
</body>
</html>
