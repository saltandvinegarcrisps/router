<?php

namespace spec\Routing;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class UriMatcherSpec extends ObjectBehavior {

	public function it_is_initializable() {
		$this->shouldHaveType('Routing\UriMatcher');
	}

	public function it_should_return_false_on_no_match() {
		$this->match('/fail')->shouldBe(false);
	}

	public function it_should_match_route_by_string() {
		$this->beConstructedWith(['/foo' => 'bar']);

		$this->matchString('/foo')->shouldBeEqualTo('bar');
	}

	public function it_should_match_route_by_pattern() {
		$this->beConstructedWith(['/post/[0-9]+/edit' => 'bar']);

		$this->matchPattern('/post/263536/edit')->shouldBeEqualTo('bar');
	}

	public function it_should_match_pattern_and_set_tokens() {
		$this->beConstructedWith(['/post/:id/edit' => 'bar']);

		$this->matchPattern('/post/172363/edit')->shouldBeEqualTo('bar');

		$this->getParams()->shouldHaveKey('id');
	}

}
