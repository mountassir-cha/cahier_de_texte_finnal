<?php

namespace App\Policies;

use App\Models\Course;
use App\Models\Professor;
use Illuminate\Auth\Access\HandlesAuthorization;

class CoursePolicy
{
    use HandlesAuthorization;

    public function update(Professor $professor, Course $course)
    {
        return $professor->id === $course->professor_id;
    }

    public function delete(Professor $professor, Course $course)
    {
        return $professor->id === $course->professor_id;
    }
} 