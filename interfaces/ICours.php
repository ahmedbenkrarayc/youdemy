<?php

interface ICours{
    public function createCourse($tags);
    public function updateCourse($tags);
    public function deleteCourse();
    public function getAllCourse();
    public function getOneCourse();
}