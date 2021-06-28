<?php

namespace app\components;

use yii\web\UrlRule;

class CatalogUrlRule extends UrlRule
{

    public function createUrl($manager, $route, $params)
    {
        if ($route === 'catalog') {
            if (isset($params['manufacturer'], $params['model'])) {
                return $params['manufacturer'] . '/' . $params['model'];
            } elseif (isset($params['manufacturer'])) {
                return $params['manufacturer'];
            }
        }

        return false;
    }

    private function ifSlugReturnValue(string $string): ?string
    {
        return (preg_match('/^[\w-]+$/x', $string) === 1) ? $string : null;
    }

    public function parseRequest($manager, $request)
    {
        $pathInfo = $request->getPathInfo();
        $urlExp = explode('/', $pathInfo);
        $params = array_merge($this->defaults, [
            'brand' => (isset($urlExp[1])) ? $this->ifSlugReturnValue($urlExp[1]) : null,
            'model' => (isset($urlExp[2])) ? $this->ifSlugReturnValue($urlExp[2]) : null,
        ]);

        if ($urlExp[0] === 'catalog') {
            preg_match_all('/\/(?:(\w+)=([\w-]+))/m', $pathInfo, $matches2, PREG_SET_ORDER);

            if (!empty($matches2)) {

                foreach ($matches2 as $item) {
                    $params[$item[1]] = $item[2];
                }
            }

            return [
                'site/index', $params
            ];
        }
        return false;
    }
}