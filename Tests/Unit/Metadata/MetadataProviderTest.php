<?php

namespace Happyr\SerializerBundle\Tests\Unit\Metadata;

use Happyr\SerializerBundle\Metadata\AnnotationReader;
use Happyr\SerializerBundle\Metadata\MetadataProvider;

class MetadataProviderTest extends \PHPUnit_Framework_TestCase
{
    public function testGetMetadata()
    {
        $reader0 = $this->getMock(AnnotationReader::class);
        $reader0->expects($this->once())
            ->method('getMetadata')
            ->willReturn(['m0', 'm1']);
        $reader1 = $this->getMock(AnnotationReader::class);
        $reader1->expects($this->once())
            ->method('getMetadata')
            ->willReturn(['m2', 'm3']);

        $metadataReader = new MetadataProvider([$reader0, $reader1]);
        $result = $metadataReader->getMetadata();

        $this->assertTrue(in_array('m0', $result));
        $this->assertTrue(in_array('m1', $result));
        $this->assertTrue(in_array('m2', $result));
        $this->assertTrue(in_array('m3', $result));
    }
}
