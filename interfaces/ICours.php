<?php

interface ICours{
    public function createCourse($tags);
    public function updateCourse();
    public function deleteCourse();
    public function getAllCourse();
    public function getOneCourse();
}