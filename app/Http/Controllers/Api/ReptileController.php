<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class ReptileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $url = "https://creator.douyin.com/janus/douyin/creator/data/item_analysis/content_analysis";
//        {"start_date":"20240622","end_date":"20240920","genres":[1,2,3,4,5],
//            "primary_verticals":["美食","三农"],"horizontal_axis":1,"vertical_axis":1,"content_type_request_catalog":1}
        $data = [
            'start_date'=>'20240622',
            'end_date'=>'20240920',
            'genres'=>[1,2,3,4,5],
            'primary_verticals'=>["美食","三农"],
            'horizontal_axis'=>1,
            'vertical_axis'=>1,
            'content_type_request_catalog'=>1,
        ];
        $headers = [
            'Cache-Control'=>'no-cache',
            'Content-Length'=>'179',
            'Content-Type'=>'application/json',
            'Cookie'=>'store-region=cn-hn; store-region-src=uid; __live_version__=%221.1.1.4374%22; UIFID_TEMP=96cd3b166f3029d7c1cc3f64582454ab8a83ff1f9e6d6689076dd47ef1dca5f82972a86282f3c1f3df9cbe7c21f5e0a3847b85f22e1b3bf89adbc9795026e235b7402d4bb800017078bdb66d6c8c8843; passport_csrf_token=4ec0504fc3f694381bff4c4def7c1203; passport_csrf_token_default=4ec0504fc3f694381bff4c4def7c1203; bd_ticket_guard_client_web_domain=2; _bd_ticket_crypt_doamin=2; __security_server_data_status=1; SEARCH_RESULT_LIST_TYPE=%22single%22; hevc_supported=true; SelfTabRedDotControl=%5B%5D; volume_info=%7B%22isUserMute%22%3Afalse%2C%22isMute%22%3Atrue%2C%22volume%22%3A0.62%7D; publish_badge_show_info=%220%2C0%2C0%2C1726475952872%22; is_staff_user=false; my_rd=2; FORCE_LOGIN=%7B%22videoConsumedRemainSeconds%22%3A180%2C%22isForcePopClose%22%3A1%7D; download_guide=%223%2F20240916%2F1%22; pwa2=%220%7C0%7C3%7C1%22; csrf_session_id=75f868dba09461370d1a7e3689c54b05; _tea_utm_cache_2906=undefined; strategyABtestKey=%221726647404.55%22; FRIEND_NUMBER_RED_POINT_INFO=%22MS4wLjABAAAAdcIZqglxLtwvfB-h1FWDmL44dRLB9JxtjkQfaFG3wLuEcA9oWoSW_e8M7Bg8QI7j%2F1726675200000%2F1726647413527%2F0%2F0%22; FOLLOW_LIVE_POINT_INFO=%22MS4wLjABAAAAdcIZqglxLtwvfB-h1FWDmL44dRLB9JxtjkQfaFG3wLuEcA9oWoSW_e8M7Bg8QI7j%2F1726675200000%2F1726647416311%2F1726647413871%2F0%22; stream_recommend_feed_params=%22%7B%5C%22cookie_enabled%5C%22%3Atrue%2C%5C%22screen_width%5C%22%3A1920%2C%5C%22screen_height%5C%22%3A1080%2C%5C%22browser_online%5C%22%3Atrue%2C%5C%22cpu_core_num%5C%22%3A4%2C%5C%22device_memory%5C%22%3A8%2C%5C%22downlink%5C%22%3A1.35%2C%5C%22effective_type%5C%22%3A%5C%223g%5C%22%2C%5C%22round_trip_time%5C%22%3A500%7D%22; FOLLOW_NUMBER_YELLOW_POINT_INFO=%22MS4wLjABAAAAdcIZqglxLtwvfB-h1FWDmL44dRLB9JxtjkQfaFG3wLuEcA9oWoSW_e8M7Bg8QI7j%2F1726675200000%2F0%2F0%2F1726662939436%22; home_can_add_dy_2_desktop=%221%22; WallpaperGuide=%7B%22showTime%22%3A1726476471840%2C%22closeTime%22%3A0%2C%22showCount%22%3A1%2C%22cursor1%22%3A22%2C%22cursor2%22%3A6%7D; s_v_web_id=verify_m17ydfrj_80a242f1_b521_73be_8cb4_9b8844f0f586; passport_mfa_token=CjeucdasH8sAET3gv9MF3trdtU1tbjmyiyW6Bk96tfh92gjNT9gF6sW%2BMX5xHFC65s22X3K2D61HGkoKPO4Cu8XYnASVqG16x8UtqShKNmmAJeub%2Bov8ruK3iJPk2WpyEA%2BcRvbAQlpTmRDU0x9DK24l13WyBbwa4xDDutwNGPax0WwgAiIBAzoIoIY%3D; d_ticket=cb8575bce7662388d38be2e855f08732c666b; n_mh=ZjMiL66RU3PLQeQ-F7-oS9i-m7MM6eU0ymDp-Y_OIdY; sso_auth_status=036e049465386b58e8ad81881147d899%2C1758b92338792896834689185305cb9c; sso_auth_status_ss=036e049465386b58e8ad81881147d899%2C1758b92338792896834689185305cb9c; oc_login_type=LOGIN_PERSON; IsDouyinActive=false; stream_player_status_params=%22%7B%5C%22is_auto_play%5C%22%3A1%2C%5C%22is_full_screen%5C%22%3A0%2C%5C%22is_full_webscreen%5C%22%3A0%2C%5C%22is_mute%5C%22%3A1%2C%5C%22is_speed%5C%22%3A1%2C%5C%22is_visible%5C%22%3A0%7D%22; biz_trace_id=6c876b13; passport_assist_user=CkHHib_-DP1r57X4I5xh-KHe9BwKmIgzIfvZZUkiZqUHQZ0JywWvmzGXWOgzF97czJdf5wZTTO7377yVTowWHsWSaBpKCjzmSqoA1WAxXrb9ev9tu-ArPeY4rq3h-Z0jDvBe5QY2ypGNZ4QfmxpsbsC3vHUZaQ9YLXC__bisAe1o9X4Q-NDcDRiJr9ZUIAEiAQPHrEex; sso_uid_tt=a4cbf5f5dd25cdf52e45c729f856c11a; sso_uid_tt_ss=a4cbf5f5dd25cdf52e45c729f856c11a; toutiao_sso_user=f90f5973604fda8f0450e32e5a7c67ac; toutiao_sso_user_ss=f90f5973604fda8f0450e32e5a7c67ac; sid_ucp_sso_v1=1.0.0-KDU3MDNkNTlhZjU5MGJiYzY5Mzg4Y2JhNzBjMzE3ZjllMTYwYTYyNjAKIQikyIDM3YzCBBDf-7W3BhjaFiAMMJ679ooGOAZA9AdIBhoCbGYiIGY5MGY1OTczNjA0ZmRhOGYwNDUwZTMyZTVhN2M2N2Fj; ssid_ucp_sso_v1=1.0.0-KDU3MDNkNTlhZjU5MGJiYzY5Mzg4Y2JhNzBjMzE3ZjllMTYwYTYyNjAKIQikyIDM3YzCBBDf-7W3BhjaFiAMMJ679ooGOAZA9AdIBhoCbGYiIGY5MGY1OTczNjA0ZmRhOGYwNDUwZTMyZTVhN2M2N2Fj; odin_tt=a512b2d67a1adca0677e141304443800fa1f888c6318b8ffa6c14097e1dcbfa44f50515c2f9f2fe48ec991791045e0e80e949dcc8d9f350452602a537230731c; passport_auth_status=55d7e64275cffc1d684ce6e6bd54d739%2Cca00e44feb9d8744d86799fdc3cea0a9; passport_auth_status_ss=55d7e64275cffc1d684ce6e6bd54d739%2Cca00e44feb9d8744d86799fdc3cea0a9; uid_tt=d4ea8e8a1f2710f1c51d388938829549; uid_tt_ss=d4ea8e8a1f2710f1c51d388938829549; sid_tt=7f20a92f4df8dbddf4dc11fb2cd09924; sessionid=7f20a92f4df8dbddf4dc11fb2cd09924; sessionid_ss=7f20a92f4df8dbddf4dc11fb2cd09924; ttwid=1%7CNtV0V2GRH4nADMQlr1gSFMbZfxdzsH6Nq6leTPcvJW8%7C1726840289%7C5c23e3c44509cfcd28e524193d89f493413822a62c490b97155480ae6754b5c3; _bd_ticket_crypt_cookie=e7ecd1dd6d20b9a05ac0314d857409dd; bd_ticket_guard_client_data=eyJiZC10aWNrZXQtZ3VhcmQtdmVyc2lvbiI6MiwiYmQtdGlja2V0LWd1YXJkLWl0ZXJhdGlvbi12ZXJzaW9uIjoxLCJiZC10aWNrZXQtZ3VhcmQtcmVlLXB1YmxpYy1rZXkiOiJCUFAvaVNqelhHZmFjNlhhdVFlRGRvdGorM2JIYzU2MFp5TDZoNk93Nis4Y001WW9BVURDOENoUkhCeTNXZEcvd0J5ZnVmUW12ZnVya3c0RytmdjZwSnc9IiwiYmQtdGlja2V0LWd1YXJkLXdlYi12ZXJzaW9uIjoxfQ%3D%3D; passport_fe_beating_status=true; sid_guard=7f20a92f4df8dbddf4dc11fb2cd09924%7C1726840292%7C5183998%7CTue%2C+19-Nov-2024+13%3A51%3A30+GMT; sid_ucp_v1=1.0.0-KGM5MzgzNWU5NzhlMTg1YmFiMTA5ZDk0NTM4NzdhZGY2ZjliZDE3ODAKGwikyIDM3YzCBBDk-7W3BhjaFiAMOAZA9AdIBBoCbGYiIDdmMjBhOTJmNGRmOGRiZGRmNGRjMTFmYjJjZDA5OTI0; ssid_ucp_v1=1.0.0-KGM5MzgzNWU5NzhlMTg1YmFiMTA5ZDk0NTM4NzdhZGY2ZjliZDE3ODAKGwikyIDM3YzCBBDk-7W3BhjaFiAMOAZA9AdIBBoCbGYiIDdmMjBhOTJmNGRmOGRiZGRmNGRjMTFmYjJjZDA5OTI0; msToken=go--txb6bp-MDAe0GI-Px5hnLIpwGBOcEmQu6YYCvQdYzLQPX9oZINssnJBpH0Rc9DS8px15YYnMjZTiOIsCaCryCcEtAtBfZw7E2dZr05jE3y6QTy0z; tt_scid=67SEXdSgWeF1goLbgLAY9hrEV9n8IHZflzvXshzo-WzqPod1rep77eTsQufjjw6tb15e',
            'User-Agent'=> 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/128.0.0.0 Safari/537.36',
        ];

        try {
            $client = new Client();
            // 发送 POST 请求
            $response = $client->request('POST', $url, [
                'headers' => $headers,
                'json'    => $data, // 如果你需要发送 JSON 格式的数据
                // 'form_params' => $data, // 如果你需要发送表单格式的数据
            ]);

            // 获取响应状态码
            $statusCode = $response->getStatusCode();

            // 获取响应体
            $body = $response->getBody()->getContents();

            // 输出响应内容
            echo "Response Status: " . $statusCode . "\n";
            echo "Response Body: " . $body . "\n";
        } catch (RequestException $e) {
            // 处理请求异常
            echo "Error: " . $e->getMessage() . "\n";
            if ($e->hasResponse()) {
                echo "Response: " . $e->getResponse()->getBody()->getContents() . "\n";
            }
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}