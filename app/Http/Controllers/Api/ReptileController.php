<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\DB;

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
        //{"start_date":"20240715","end_date":"20241013","genres":[1,2,3,4,5],
            //"primary_verticals":["美食"],"horizontal_axis":1,"vertical_axis":1,"content_type_request_catalog":1}
        $data = [
            'start_date'=>'20240715',
            'end_date'=>'20241013',
            'genres'=>[1,2,3,4,5],
            'primary_verticals'=>["美食"],
            'horizontal_axis'=>1,
            'vertical_axis'=>1,
            'content_type_request_catalog'=>1,
        ];
        $headers = [
            'Cache-Control'=>'no-cache',
            'Content-Length'=>'179',
            'Content-Type'=>'application/json',
	    'Cookie' => 'store-region=cn-hn; store-region-src=uid; __live_version__=%221.1.1.4374%22; UIFID_TEMP=96cd3b166f3029d7c1cc3f64582454ab8a83ff1f9e6d6689076dd47ef1dca5f82972a86282f3c1f3df9cbe7c21f5e0a3847b85f22e1b3bf89adbc9795026e235b7402d4bb800017078bdb66d6c8c8843; bd_ticket_guard_client_web_domain=2; _bd_ticket_crypt_doamin=2; __security_server_data_status=1; SEARCH_RESULT_LIST_TYPE=%22single%22; hevc_supported=true; SelfTabRedDotControl=%5B%5D; is_staff_user=false; my_rd=2; csrf_session_id=75f868dba09461370d1a7e3689c54b05; s_v_web_id=verify_m17ydfrj_80a242f1_b521_73be_8cb4_9b8844f0f586; passport_mfa_token=CjeucdasH8sAET3gv9MF3trdtU1tbjmyiyW6Bk96tfh92gjNT9gF6sW%2BMX5xHFC65s22X3K2D61HGkoKPO4Cu8XYnASVqG16x8UtqShKNmmAJeub%2Bov8ruK3iJPk2WpyEA%2BcRvbAQlpTmRDU0x9DK24l13WyBbwa4xDDutwNGPax0WwgAiIBAzoIoIY%3D; sso_auth_status=036e049465386b58e8ad81881147d899%2C1758b92338792896834689185305cb9c; sso_auth_status_ss=036e049465386b58e8ad81881147d899%2C1758b92338792896834689185305cb9c; oc_login_type=LOGIN_PERSON; d_ticket=3b29078fc1a25f85df6fe42b44d40858c666b; passport_assist_user=CkEFPHWBVB3hPXoWhSOSWYsHNtGd7zgBhNdbA6MI_F6OXRKEkCrLhHZ6rna4jR77KIduBjsXCVTe4gSDBZ3kQms4mBpKCjzRL6v3XQo3JKi54AY3AZJZsMniCvKoCNrV0g8zaJpVIO11FLs8NUfjitGRXBMJnHe8aELCgmjRXTPvSyMQ_eDcDRiJr9ZUIAEiAQO9WsF5; n_mh=mvoV9Lb1RI1bTYI46tAYcZw6PxyhlvSMIraDr7P0Y1c; sso_uid_tt=488e6af81792972210370782b1737746; sso_uid_tt_ss=488e6af81792972210370782b1737746; toutiao_sso_user=08f0d668b17c02dd5f7506aaae63c748; toutiao_sso_user_ss=08f0d668b17c02dd5f7506aaae63c748; sid_ucp_sso_v1=1.0.0-KGU3ZTI1M2U0NjhlODFiMDJmZjhhZThhMWI5OTFiOTRlNmUyYzU1ZDQKIQi0gcDB2fWYBBD3hL63BhjaFiAMMLWJ5uYFOAJA8QdIBhoCaGwiIDA4ZjBkNjY4YjE3YzAyZGQ1Zjc1MDZhYWFlNjNjNzQ4; ssid_ucp_sso_v1=1.0.0-KGU3ZTI1M2U0NjhlODFiMDJmZjhhZThhMWI5OTFiOTRlNmUyYzU1ZDQKIQi0gcDB2fWYBBD3hL63BhjaFiAMMLWJ5uYFOAJA8QdIBhoCaGwiIDA4ZjBkNjY4YjE3YzAyZGQ1Zjc1MDZhYWFlNjNjNzQ4; passport_auth_status=a66ca3e2079f255dec1f88e9661db49c%2Ccf7cee92661d89058570e946033f6939; passport_auth_status_ss=a66ca3e2079f255dec1f88e9661db49c%2Ccf7cee92661d89058570e946033f6939; uid_tt=d40cb9c87a7d3a2660d85c5bb9c11e88; uid_tt_ss=d40cb9c87a7d3a2660d85c5bb9c11e88; sid_tt=1df83c909d9222c909b4e26e22d270ae; sessionid=1df83c909d9222c909b4e26e22d270ae; sessionid_ss=1df83c909d9222c909b4e26e22d270ae; _bd_ticket_crypt_cookie=b242be43f5853a09a26445b8c3775af2; sid_guard=1df83c909d9222c909b4e26e22d270ae%7C1726972542%7C5183995%7CThu%2C+21-Nov-2024+02%3A35%3A37+GMT; sid_ucp_v1=1.0.0-KDAwYmY2ZDVhYzgxMjQ0YWI5NDc4MjQ4MWMwNTdkMzFlMTY2ZDdhYjYKGwi0gcDB2fWYBBD-hL63BhjaFiAMOAJA8QdIBBoCaGwiIDFkZjgzYzkwOWQ5MjIyYzkwOWI0ZTI2ZTIyZDI3MGFl; ssid_ucp_v1=1.0.0-KDAwYmY2ZDVhYzgxMjQ0YWI5NDc4MjQ4MWMwNTdkMzFlMTY2ZDdhYjYKGwi0gcDB2fWYBBD-hL63BhjaFiAMOAJA8QdIBBoCaGwiIDFkZjgzYzkwOWQ5MjIyYzkwOWI0ZTI2ZTIyZDI3MGFl; biz_trace_id=4cd5db5d; volume_info=%7B%22isUserMute%22%3Afalse%2C%22isMute%22%3Afalse%2C%22volume%22%3A0.62%7D; stream_recommend_feed_params=%22%7B%5C%22cookie_enabled%5C%22%3Atrue%2C%5C%22screen_width%5C%22%3A1440%2C%5C%22screen_height%5C%22%3A900%2C%5C%22browser_online%5C%22%3Atrue%2C%5C%22cpu_core_num%5C%22%3A4%2C%5C%22device_memory%5C%22%3A8%2C%5C%22downlink%5C%22%3A10%2C%5C%22effective_type%5C%22%3A%5C%224g%5C%22%2C%5C%22round_trip_time%5C%22%3A50%7D%22; FOLLOW_NUMBER_YELLOW_POINT_INFO=%22MS4wLjABAAAAdcIZqglxLtwvfB-h1FWDmL44dRLB9JxtjkQfaFG3wLuEcA9oWoSW_e8M7Bg8QI7j%2F1728835200000%2F0%2F1728821025347%2F0%22; home_can_add_dy_2_desktop=%221%22; publish_badge_show_info=%220%2C0%2C0%2C1728821029831%22; IsDouyinActive=false; download_guide=%221%2F20241013%2F0%22; pwa2=%220%7C0%7C1%7C0%22; odin_tt=3ead34ef5766c364b78827bb8c47d0b63960ebb8506965ace857ac49f26521e99aa137ac7fec71204c97394ffae72f2a75c6ebc89bc305548e7322ec9f08658e; ttwid=1%7CNtV0V2GRH4nADMQlr1gSFMbZfxdzsH6Nq6leTPcvJW8%7C1728825526%7Ca20f2c86ea8f4d9a4cc2a17700d01a071441c07dd7f78735a73b26ef9323ac62; bd_ticket_guard_client_data=eyJiZC10aWNrZXQtZ3VhcmQtdmVyc2lvbiI6MiwiYmQtdGlja2V0LWd1YXJkLWl0ZXJhdGlvbi12ZXJzaW9uIjoxLCJiZC10aWNrZXQtZ3VhcmQtcmVlLXB1YmxpYy1rZXkiOiJCUFAvaVNqelhHZmFjNlhhdVFlRGRvdGorM2JIYzU2MFp5TDZoNk93Nis4Y001WW9BVURDOENoUkhCeTNXZEcvd0J5ZnVmUW12ZnVya3c0RytmdjZwSnc9IiwiYmQtdGlja2V0LWd1YXJkLXdlYi12ZXJzaW9uIjoyfQ%3D%3D; passport_fe_beating_status=true; tt_scid=ufDZFLm9PEY5vSFa9D7RPmeooxlvGHU73s.KHZmXC4-USm4Is3WE8RlMbh237Jmg4605; msToken=X4ja0l3CWGa1p7krRQ1VMIiYQW6zL1RVvzM4OFnY4l9d_RGcK-Q4rHBVZ5xcECqadMEKlaaUrsF4RDIYmcwATIbMqf-3ZYPTs205Kg_w4L6phoZnrnnyMTxPpVDIuoo=',
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
            $resultBody = json_decode($body,true);

            // 输出响应内容
            echo "Response Status: " . $statusCode . "\n";
            echo "Response Body: " . $body . "\n";
            if ($statusCode != 200 || $resultBody['status_code'] != 0) {
                throw new RequestException('Response fail. Status:'.$statusCode.' Body:'.$body);
            }

            $itemStatisticsList = $resultBody['item_statistics'];
            foreach ($itemStatisticsList as $item) {
                $data = [
                    'average_play_duration' => $item['average_play_duration'], // 平均播放时长：9
                    'bounce_rate_2s' => $item['bounce_rate_2s'], // 2m跳出率：0.4117647058823529
                    'comment_count' => $item['comment_count'], // 评论数:0
                    'completion_rate_5s' => $item['completion_rate_5s'], // 5s完播率:0.35294117647058826
                    'like_count' =>$item['like_count'], // 点赞数:1
                    'play_count'=>$item['play_count'], // 播放数：16
                    'play_percentage' => $item['play_percentage'], // 播放率:1.1428571428571428
                    'share_count' => $item['share_count'], // 分享数：0
                    'title' => $item['title'], // 标题
                ];
                DB::table('dy_item')->insert($data);
            }

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
