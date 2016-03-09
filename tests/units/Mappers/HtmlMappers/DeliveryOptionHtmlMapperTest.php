<?php

use Symfony\Component\DomCrawler\Crawler;
use Jne\Mappers\HtmlMappers\DeliveryOptionHtmlMapper;
use Jne\Contracts\Foundation\DeliveryOptionInterface;

class DeliveryOptionHtmlMapperTest extends PHPUnit_Framework_TestCase {
    protected $htmlDeliveryOptions;

    function setUp()
    {
        $this->htmlDeliveryOptions = <<<EOD
<table></table>
<table>
    <tbody>
        <tr>
            <td>OKE</td>
            <td>Dokumen</td>
            <td>
                <table border=0 width=100%>
                    <tr>
                        <td>Rp.</td>
                        <td>10,000</td>
                    </tr>
                </table>
            </td>
            <td>2-3 Days</td>
        </tr>
        <tr>
            <td>REG</td>
            <td>Dokumen</td>
            <td>
                <table border=0 width=100%>
                    <tr>
                        <td>Rp.</td>
                        <td>15,000</td>
                    </tr>
                </table>
            </td>
            <td>1-2 Days</td>
        </tr>
    </tbody>
</table>
EOD;
    }

    /** @test */
    function delivery_option_html_mapper_can_map_html_dom()
    {
        $deliveryOptionHtmlMapper = new DeliveryOptionHtmlMapper();

        $deliveryOptions = $deliveryOptionHtmlMapper->map(new Crawler($this->htmlDeliveryOptions));

        $this->assertCount(2, $deliveryOptions);

        foreach ($deliveryOptions as $deliveryOption) {
            $this->assertInstanceOf(DeliveryOptionInterface::class, $deliveryOption);
        }

        $this->assertEquals('REG', $deliveryOptions[1]->service());
        $this->assertEquals('Dokumen', $deliveryOptions[1]->type());
        $this->assertEquals(15000, $deliveryOptions[1]->tariff());
        $this->assertEquals('1-2 Days', $deliveryOptions[1]->estimatedDays());
    }
}
