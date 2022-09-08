<h2>Insatgram Feed</h2>

<h3>Step: 1</h3>
<p>Create laravel project</p>
<div class="highlight">
<pre class="highlight plaintext">
<code>
    composer create-project --prefer-dist laravel/laravel instagram_feed
</code>
</pre>
</div>

<h3>Step: 2</h3>
<p>
<a href="https://developers.facebook.com/docs/instagram-basic-display-api/getting-started"> Create Instagram access token from this link</a>
</p>

<h3>Step: 3</h3>

<div class="highlight">
   <pre class="highlight plaintext">
   <code>
    INSTAGRAM_ACCESS_TOKEN=""
</code></pre>
</div>

<h3>Step: 4</h3>
<p> Make controller InstagramFeedController</p>
<div class="highlight">
   <pre class="highlight plaintext"><code>
    namespace App\Http\Controllers;

    use Illuminate\Http\Request;

    class InstagramFeedController extends Controller
    {
   

        public function getInstagram(){
                $data                   = [];
            $limit                  = 4;
            $token                  = env('INSTAGRAM_ACCESS_TOKEN');
            $fields                 = "id,media_type,media_url,thumbnail_url,timestamp,permalink,caption";
            $instafeeds             = $this->getInstagramPost($fields,$token,$limit);
            return view('welcome')->withRows($instafeeds);
        }

        public function getInstagramPost($fields,$token,$limit){
                $url = "https://graph.instagram.com/me/media?fields=".$fields.'&access_token='.$token.'&limit='.$limit;
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($ch, CURLOPT_TIMEOUT, 20);
                $result = curl_exec($ch);
                curl_close($ch);
                $result_decode = json_decode($result, true);
                return $result_decode;
        }

    

    }

</code></pre>
</div>
<h3>Step: 5</h3>

<div class="highlight">
   <pre class="highlight plaintext">
   <code>
        @if(!empty($rows))
        @foreach($rows as $row)
        <div class="col-6 col-sm-3 col-md-3">
            <div class="insta-grid">
                <a href="{{$row->permalink}}" target="__blank">
                <div class="img-featured-container">
                    <div class="img-backdrop"></div>
                    <div class="description-container">
                    <p class="caption text-white">{{$row->caption}}</p>
                    </div>
                <img src="{{$row->thumbnail_url}}" class="img-fluid lazy">
                </div>
            </a>
            </div>
        </div>
    @endforeach
    @endif
</code></pre>
</div>
