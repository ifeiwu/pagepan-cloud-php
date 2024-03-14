<?php

namespace PagepanCloud;

class WebsiteClient
{
    public $baseurl = 'https://v2.api.pagepan.com/website/';

    public $token = null;

    /**
     * @param string $token 商户密钥
     */
    public function __construct(string $token)
    {
        $this->token = $token;
    }

    /**
     * 添加网站基本信息
     * 在进行向导安装网站之前，先调用这个接口记录网站信息
     * 否则不能记录【合作伙伴名称】，安装完成会自动更新网站其它信息
     * @param string $url 网站入口链接
     * @return array
     */
    public function addInfo(string $url): array
    {
        return $this->send('add-info', ['url' => $url]);
    }

    /**
     * 更新网站信息
     * @param string $url 网站入口链接
     * @param array $params 更新网站需要的参数：
     * $params['state'] = 1 // 网站状态：0禁用，1启用【可填】
     * $params['title'] = 'test' // 网站标题。【可填】
     * $params['email'] = 'test@qq.com' // 网站管理员邮箱。【可填】
     * $params['version'] = '7.25.5' // 网站版本号。【可填】
     * $params['end_date'] = '2024-08-01' // 网站结束日期。0表示无限期【可填】
     * $params['admin_url'] = 'https://www.test.com/admin' // 后台链接地址。【可填】
     * @return array
     */
    public function update(string $url, array $params): array
    {
        $params['url'] = $url;

        return $this->send('update', $params);
    }

    /**
     * 删除网站信息
     * @param string $url 网站入口链接
     * @return array
     */
    public function delete(string $url): array
    {
        return $this->send('delete', ['url' => $url]);
    }

    /**
     * 获取网站信息
     * @param string $url 网站入口链接
     * @return array
     */
    public function find(string $url): array
    {
        return $this->send('find', ['url' => $url]);
    }

    /**
     * 获取当前网站域名所有子网站列表
     * @param string $url 网站入口链接
     * @return array
     */
    public function findChild(string $url): array
    {
        return $this->send('find-child', ['url' => $url]);
    }

    /**
     * 获取所有网站列表
     * @param array $params 分页参数：
     * $params['pagenum'] = 1 // 当前页码。【可填】
     * $params['perpage'] = 20 // 每页条数据。【可填】
     * @return array
     */
    public function list(array $params = []): array
    {
        return $this->send('list', $params);
    }

    /**
     * 发送接口请求
     * @param string $path 路径
     * @param array $params 参数
     * @return array
     */
    public function send(string $path, array $params = []): array
    {
        $curl = new \Curl\Curl();
        $curl->setJsonDecoder(function($response) {
            return json_decode($response, true);
        });
        $curl->setHeader('Authorization', sprintf('Bearer %s', $this->token));
        $curl->post($this->baseurl . $path, $params);

        if ($curl->error) {
            $message = $curl->errorMessage;
//            $curl->diagnose();
            return ['code' => 1, 'data' => null, 'message' => $curl->errorMessage];
        }

        return $curl->response;
    }
}