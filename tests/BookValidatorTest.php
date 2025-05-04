<?php

use PHPUnit\Framework\TestCase;
use App\Validators\BookValidator;

class BookValidatorTest extends TestCase
{
    public function testValidCreateDataPasses()
    {
        $data = [
            'title' => 'Valid Book',
            'author_id' => 1,
            'year' => 2023,
            'genre_id' => 2
        ];
        $errors = BookValidator::validateCreate($data);
        $this->assertEmpty($errors);
    }

    public function testCreateFailsWithMissingFields()
    {
        $errors = BookValidator::validateCreate([]);
        $this->assertContains('Title is required.', $errors);
        $this->assertContains('Valid author ID is required.', $errors);
        $this->assertContains('Year must be between 1000 and current year.', $errors);
        $this->assertContains('Valid genre ID is required.', $errors);
    }

    public function testCreateFailsOnEmptyTitle()
    {
        $data = [
            'title' => '',
            'author_id' => 1,
            'year' => 2023,
            'genre_id' => 1
        ];
        $errors = BookValidator::validateCreate($data);
        $this->assertContains('Title is required.', $errors);
    }

    public function testCreateFailsOnInvalidAuthorId()
    {
        $data = [
            'title' => 'Book',
            'author_id' => -5,
            'year' => 2023,
            'genre_id' => 1
        ];
        $errors = BookValidator::validateCreate($data);
        $this->assertContains('Valid author ID is required.', $errors);
    }

    public function testCreateFailsOnFutureYear()
    {
        $data = [
            'title' => 'Book',
            'author_id' => 1,
            'year' => date('Y') + 5,
            'genre_id' => 1
        ];
        $errors = BookValidator::validateCreate($data);
        $this->assertContains('Year must be between 1000 and current year.', $errors);
    }

    public function testCreateFailsOnInvalidGenreId()
    {
        $data = [
            'title' => 'Book',
            'author_id' => 1,
            'year' => 2022,
            'genre_id' => 0
        ];
        $errors = BookValidator::validateCreate($data);
        $this->assertContains('Valid genre ID is required.', $errors);
    }

    public function testUpdateFailsOnMissingId()
    {
        $data = [
            'title' => 'Updated Book',
            'author_id' => 1,
            'year' => 2022,
            'genre_id' => 1
        ];
        $errors = BookValidator::validateUpdate($data);
        $this->assertContains('Valid book ID is required.', $errors);
    }

    public function testUpdateFailsOnInvalidId()
    {
        $data = [
            'id' => -10,
            'title' => 'Updated Book',
            'author_id' => 1,
            'year' => 2022,
            'genre_id' => 1
        ];
        $errors = BookValidator::validateUpdate($data);
        $this->assertContains('Valid book ID is required.', $errors);
    }

    public function testUpdatePassesWithValidData()
    {
        $data = [
            'id' => 1,
            'title' => 'Updated Book',
            'author_id' => 1,
            'year' => 2022,
            'genre_id' => 1
        ];
        $errors = BookValidator::validateUpdate($data);
        $this->assertEmpty($errors);
    }

    public function testValidateDeleteWithValidId()
    {
        $data = ['id' => 5];
        $errors = BookValidator::validateDelete($data);
        $this->assertEmpty($errors);
    }

    public function testValidateDeleteWithInvalidId()
    {
        $data = ['id' => -1];
        $errors = BookValidator::validateDelete($data);
        $this->assertContains('Valid book ID is required.', $errors);
    }
}
