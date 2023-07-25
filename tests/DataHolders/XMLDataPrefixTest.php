<?php

declare(strict_types=1);

namespace Wrkflow\GetValueTests\DataHolders;

use PHPUnit\Framework\TestCase;
use SimpleXMLElement;
use Wrkflow\GetValue\DataHolders\XMLData;
use Wrkflow\GetValue\Enums\ValueType;

class XMLDataPrefixTest extends TestCase
{
    public function testGetDataWithPrefix(): void
    {
        $status = $this->make(
            xml: <<<'CODE_SAMPLE'
                <?xml version="1.0" encoding="utf-8"?>
                <soap:Envelope xmlns:soap="http://www.w3.org/2003/05/soap-envelope" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema">
                <soap:Body>
                <PingResponse xmlns="http://sgs/webservice/"><PingResult><result xmlns=""><status>OK</status><datetime>21/07/2023 15:03:13</datetime></result></PingResult></PingResponse>
                </soap:Body>
                </soap:Envelope>
                CODE_SAMPLE
            ,
            key: ['soap:Body', 'PingResponse', 'PingResult', 'result', 'status'],
            expectedValueType: ValueType::String
        );
        $this->assertSame('OK', $status);
    }

    public function testGetDataWithMultiplePrefix(): void
    {
        $data = $this->makeData(
            xml: <<<'CODE_SAMPLE'
                <?xml version="1.0" encoding="UTF-8"?>
                <SOAP-ENV:Envelope xmlns:SOAP-ENC="http://schemas.xmlsoap.org/soap/encoding/"
                                   xmlns:SOAP-ENV="http://schemas.xmlsoap.org/soap/envelope/">
                    <SOAP-ENV:Body>
                        <urn:Z.Response xmlns:urn="urn:sap-com:document:sap:rfc:functions">
                            <ET_RETURN>
                                <item>
                                    <TYPE>S</TYPE>
                                    <ROW>1</ROW>
                                </item>
                                <item>
                                    <TYPE>S</TYPE>
                                    <ROW>2</ROW>
                                </item>
                            </ET_RETURN>
                        </urn:Z.Response>
                        <urn:ZB.Response xmlns:urn="urn:sap-com:document:sap:rfc:functions">
                            <ET_RETURN>Test</ET_RETURN>
                        </urn:ZB.Response>
                    </SOAP-ENV:Body>
                    <SOAP-ENV:Body2>
                    <test>23</test>
                    </SOAP-ENV:Body2>
                    <SOAP-ENV:Body3>
                    <urn:ZB.Response xmlns:urn="urn:sap-com:document:sap:rfc:functions">Response</urn:ZB.Response>
                    </SOAP-ENV:Body3>
                </SOAP-ENV:Envelope>
                CODE_SAMPLE
            ,
        );
        $this->assertSame(
            expected: '1',
            actual: $data->getValue(
                key: ['SOAP-ENV:Body', 'urn:Z.Response', 'ET_RETURN', 'item', '0', 'ROW'],
                expectedValueType: ValueType::String
            )
        );
        $this->assertSame(
            expected: '2',
            actual: $data->getValue(
                key: ['SOAP-ENV:Body', 'urn:Z.Response', 'ET_RETURN', 'item', '1', 'ROW'],
                expectedValueType: ValueType::String
            )
        );
        $this->assertSame(
            expected: 'Test',
            actual: $data->getValue(
                key: ['SOAP-ENV:Body', 'urn:ZB.Response', 'ET_RETURN'],
                expectedValueType: ValueType::String
            ),
            message: 'Second child in urn namespace not accessible'
        );
        $this->assertSame(
            expected: '23',
            actual: $data->getValue(key: ['SOAP-ENV:Body2', 'test'], expectedValueType: ValueType::String),
            message: 'Body2 contains direct child with value'
        );
        $this->assertSame(
            expected: 'Response',
            actual: $data->getValue(
                key: ['SOAP-ENV:Body3', 'urn:ZB.Response'],
                expectedValueType: ValueType::String
            ),
            message: 'Body3 should contains urn namespace with value'
        );
    }

    protected function make(
        string $xml,
        string|array $key,
        ValueType $expectedValueType
    ): SimpleXMLElement|array|string|null {
        return $this->makeData($xml)
            ->getValue(key: $key, expectedValueType: $expectedValueType);
    }

    protected function makeData(string $xml): XMLData
    {
        return new XMLData(new SimpleXMLElement($xml));
    }
}
