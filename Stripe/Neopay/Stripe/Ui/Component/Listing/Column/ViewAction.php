<?php
/**
 * Listing action source required for Admin grid
 *
 * @category Neopay
 * @package Neopay_Stripe
 * @author Neo Team
 **/

namespace Neopay\Stripe\Ui\Component\Listing\Column;

/**
 * ViewAction Class
 */
class ViewAction extends \Magento\Sales\Ui\Component\Listing\Column\ViewAction
{
    /**
     * Prepare Data Source
     *
     * @param array $dataSource
     * @return array
     */
    public function prepareDataSource(array $dataSource)
    {
        $primaryKey = $this->getData('conafig/indexField') ?: 'index_id';

        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as & $item) {
                $links = [];

                if (isset($item[$primaryKey])) {
                    $viewUrlPath = $this->getData('config/viewUrlPath') ?: '#';
                    $urlEntityParamName = $this->getData('config/urlEntityParamName') ?: 'index_id';
                    $links['view'] = [
                        'href' => $this->urlBuilder->getUrl(
                            $viewUrlPath,
                            [
                                $urlEntityParamName => $item[$primaryKey]
                            ]
                        ),
                        'label' => __('View')
                    ];
                }

                if (!empty($links)) {
                    $item[$this->getData('name')] = $links;
                }
            }
        }

        return $dataSource;
    }
}
