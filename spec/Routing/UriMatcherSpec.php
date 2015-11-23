<?php

namespace spec\Routing;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Routing\CollectionInterface;

class UriMatcherSpec extends ObjectBehavior {

	public function it_is_initializable() {
		$this->shouldHaveType('Routing\UriMatcher');
	}

	public function it_should_return_false_on_no_match() {
		$this->match('/fail')->shouldBe(false);
	}

	public function it_should_match_route_by_string($collection) {
		$collection->beADoubleOf('Routing\RouteCollection');
		$collection->has('/foo')->willReturn(true);
		$collection->route('/foo')->willReturn('bar');

		$this->beConstructedWith($collection);
		$this->matchString('/foo')->shouldBeEqualTo('bar');
	}

	public function it_should_match_route_by_pattern($collection) {
		$collection->beADoubleOf('Routing\RouteCollection');
		$collection->getIterator()->willReturn(new \ArrayIterator(['/post/[0-9]+/edit' => 'bar']));

		$this->beConstructedWith($collection);
		$this->matchPattern('/post/263536/edit')->shouldBeEqualTo('bar');
	}

	public function it_should_match_pattern_and_set_tokens($collection) {
		$collection->beADoubleOf('Routing\RouteCollection');
		$collection->getIterator()->willReturn(new \ArrayIterator(['/post/:id/edit' => 'bar']));

		$this->beConstructedWith($collection);
		$this->matchPattern('/post/172363/edit')->shouldBeEqualTo('bar');

		$this->getParams()->shouldHaveKey('id');
	}

	public function it_should_match_pattern_and_set_optional_tokens($collection) {
		$collection->beADoubleOf('Routing\RouteCollection');
		$collection->getIterator()->willReturn(new \ArrayIterator(['/post(/:id/edit)?' => 'bar']));

		$this->beConstructedWith($collection);
		$this->matchPattern('/post/172363/edit')->shouldBeEqualTo('bar');
		$this->matchPattern('/post')->shouldBeEqualTo('bar');
	}

	public function it_should_match_resolved_aliases($collection) {
		$collection->beADoubleOf('Routing\RouteCollection');
		$collection->has('/foo')->willReturn(true);
		$collection->route('/foo')->willReturn('/bar');
		$collection->has('/bar')->willReturn(true);
		$collection->route('/bar')->willReturn('baz');

		$this->beConstructedWith($collection);
		$this->match('/foo')->shouldBeEqualTo('baz');
	}

}
