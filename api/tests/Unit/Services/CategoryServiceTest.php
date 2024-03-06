<?php

namespace Services;

use App\Services\CategoryService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Mockery;
use Mockery\MockInterface;
use Symfony\Component\HttpFoundation\File\File;
use Tests\TestCase;

class CategoryServiceTest extends TestCase
{
    use RefreshDatabase;

    public function testCreate()
    {
        $fileMock = Mockery::mock(File::class);
        $mock = Mockery::mock(UploadedFile::class, function (MockInterface $mock) use ($fileMock) {
            $mock->shouldReceive('isValid')
                ->once()
                ->andReturnTrue();
            $mock->shouldReceive('getClientOriginalExtension')
                ->once()
                ->andReturn('ext');
            $mock->shouldReceive('move')
                ->once()
                ->andReturn($fileMock);
        });

        $fakeData = [
            'name' => 'category teste',
            'image' => $mock
        ];

        /** @var CategoryService $categoryService */
        $categoryService = app(CategoryService::class);
        $categoryService->create($fakeData);

        $this->assertDatabaseCount('categories', 1);
        $this->assertDatabaseHas('categories', [
            'name' => 'category teste',
        ]);
    }
}
