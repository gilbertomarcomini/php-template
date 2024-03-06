<?php

namespace Services;

use App\Services\FileService;
use Illuminate\Http\UploadedFile;
use Mockery;
use Mockery\MockInterface;
use Tests\TestCase;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\File;

class FileServiceTest extends TestCase
{
    public function testInvalidFileMove(): void
    {
        $mockery = Mockery::mock(UploadedFile::class, function (MockInterface $mock) {
            $mock->shouldReceive('isValid')
                ->once()
                ->andReturnFalse();
        });

        $return = FileService::move($mockery, '');

        $this->assertNull($return);
    }

    public function testValidFileAndThrowFileException(): void
    {
        $this->expectException(FileException::class);

        $mock = Mockery::mock(UploadedFile::class, function (MockInterface $mock) {
            $mock->shouldReceive('isValid')
                ->once()
                ->andReturnTrue();
            $mock->shouldReceive('getClientOriginalExtension')
                ->once()
                ->andReturn('extension');
            $mock->shouldReceive('move')
                ->once()
                ->andThrow(FileException::class);
        });

        $this->assertNull(FileService::move($mock, ''));
    }

    public function testValidFileAndMove(): void {
        $fileMock = Mockery::mock(File::class);
        $mock = Mockery::mock(UploadedFile::class, function (MockInterface $mock)
        use ($fileMock) {
            $mock->shouldReceive('isValid')
                ->once()
                ->andReturnTrue();
            $mock->shouldReceive('getClientOriginalExtension')
                ->once()
                ->andReturn('extension');
            $mock->shouldReceive('move')
                ->once()
                ->andReturn($fileMock);
        });
        $filePath = FileService::move($mock, '');
        $this->assertStringEndsWith('.extension', $filePath);
    }
}
