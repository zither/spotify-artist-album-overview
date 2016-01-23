<?php

namespace Websoftwares\Spotify\Test;

use Websoftwares\Spotify\SpotifyClient;
use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Exception\RequestException;

/**
 * Class SpotifyClientTest.
 */
class SpotifyClientTest extends \PHPUnit_Framework_TestCase
{
    /**
     * spotifyClient
     *
     * @var SpotifyClient
     */
    protected $spotifyClient;

    /**
     * Setup the test suite.
     */
    public function setUp()
    {
        $this->spotifyClient = new SpotifyClient($this->getGuzzleClientMock());
    }

    /**
     * testGetArtistsAndAlbumsByIdListSucceeds
     *
     * @param  array $artistIdList
     *
     * @dataProvider artistIdListProvider
     */
    public function testGetArtistsAndAlbumsByIdListSucceeds($artistIdList)
    {
        $actual = $this->spotifyClient
            ->getArtistsAndAlbumsByIdList($artistIdList);

        $expected = '\stdObject';

        $this->assertInternalType('array', $actual->artists);
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testGetArtistsAndAlbumsByIdListFailsInvalidArgumentException()
    {
        $this->spotifyClient->getArtistsAndAlbumsByIdList();
    }

    /**
     * Returns an list of spotify id's
     *
     * @return array
     */
    public function artistIdListProvider()
    {
        $artistIdlist =  [
            [
                [
                    '6jHG1YQkqgojdEzerwvrVv',
                    '34EP7KEpOjXcM2TCat1ISk',
                    '20qISvAhX20dpIbOOzGK3q',
                    '1Z8ODXyhEBi3WynYw0Rya6',
                    '3Mcii5XWf6E0lrY3Uky4cA',
                    '3CQIn7N5CuRDP8wEI7FiDA',
                    '0eGh2jSWPBX5GuqIHoZJZG',
                    '2gINJ8xw86xawPyGvx1bla',
                    '7B4hKK0S9QYnaoqa9OuwgX',
                    '4Otx4bRLSfpah5kX8hdgDC',
                ]
            ]
        ];

        return $artistIdlist;
    }

    /**
     * Returns a guzzle client instance with configured mock handler and
     * queued responses.
     *
     * @return Client
     */
    private function getGuzzleClientMock()
    {
        $mock = new MockHandler([
            $this->getSeveralArtistsResponse(),
        ]);

        $handler = HandlerStack::create($mock);
        $client = new Client(['handler' => $handler]);

        return $client;
    }

    /**
     * Returns the response for get-several-artists request.
     *
     * @return Response
     */
    public function getSeveralArtistsResponse()
    {
        $header =  ['Content-Type' => 'application/json'];
        $protocol = '1.1';
        $status = 200;

        $body = file_get_contents(__DIR__ . '/get-several-artists.json');

        $response = new Response($status, $header, $body, $protocol);

        return $response;
    }
}