<?php

namespace Pipes\Tests\Stream;

use Pipes\Tests\TestCase;

class StreamTest extends TestCase
{
    /**
     * $stream
     *
     * @var Pipes\Stream\Stream
     */
    private $stream;

    /**
     * setUp
     *
     * @author Gustavo Vilas Boas
     * @return void
     */
    protected function setUp(): void
    {
        $this->stream = resolve('Pipes\Stream\Stream');
        parent::setUp();
    }

    /** @test */
    public function it_should_add_ations_to_the_stream_test()
    {
        $this->stream->attach('__tests', function ($text, $next) {
            $next(strtoupper($text));
        });

        $actions = $this->stream->getActions('__tests');

        $this->assertIsArray($actions);
        $this->assertCount(1, $actions);
    }

    /** @test */
    public function it_should_process_the_stream_test()
    {
        $this->stream->attach('__capitalize', function ($text, $next) {
            return $next(strtoupper($text));
        });

        $result = $this->stream->send('__capitalize', 'hello world');

        $this->assertEquals('HELLO WORLD', $result);
    }
}
