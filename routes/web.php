<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\KnowledgeBaseController;
use App\Http\Controllers\LeaderController;
use App\Http\Controllers\MediaController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StudentController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::middleware('guest.session')->group(function (): void {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.store');
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.store');
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/courses', [CourseController::class, 'catalog'])->name('courses.index');
Route::get('/courses/{slug}', [CourseController::class, 'showCourse'])->name('courses.show');
Route::get('/courses/{slug}/lessons/{lessonId}', [CourseController::class, 'showLesson'])->name('courses.lesson');

Route::middleware('role:STUDENT')->group(function (): void {
    Route::get('/student', [StudentController::class, 'dashboard'])->name('student.dashboard');
    Route::post('/lessons/{lessonId}/complete', [StudentController::class, 'completeLesson'])->name('lessons.complete');
    Route::post('/quizzes/{quizId}/submit', [StudentController::class, 'submitQuiz'])->name('quizzes.submit');
});

Route::middleware('role:ADMIN,LEADER,STUDENT')->group(function (): void {
    Route::get('/knowledge-base', [KnowledgeBaseController::class, 'index'])->name('knowledge-base');
    Route::get('/knowledge-base/assistant/search', [KnowledgeBaseController::class, 'assistantSearch'])->name('knowledge-base.assistant.search');
    Route::get('/knowledge-base/{slug}', [KnowledgeBaseController::class, 'show'])->name('knowledge-base.show');
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::post('/profile', [ProfileController::class, 'update'])->name('profile.update');
});

Route::middleware('role:LEADER')->prefix('leader')->name('leader.')->group(function (): void {
    Route::get('/', [LeaderController::class, 'dashboard'])->name('dashboard');
    Route::get('/assignments', [LeaderController::class, 'assignments'])->name('assignments');
    Route::post('/assignments', [LeaderController::class, 'assignCourse'])->name('assignments.store');
    Route::post('/trainees', [LeaderController::class, 'storeTrainee'])->name('trainees.store');
    Route::get('/team/{userId}', [LeaderController::class, 'employeeDetail'])->name('team.show');
    Route::get('/team/{userId}/edit', [LeaderController::class, 'editEmployee'])->name('team.edit');
    Route::post('/team/{userId}/edit', [LeaderController::class, 'updateEmployee'])->name('team.update');
    Route::post('/decisions/{enrollmentId}', [LeaderController::class, 'submitDecision'])->name('decisions.store');
});

Route::middleware('role:ADMIN,LEADER')->prefix('admin')->name('admin.')->group(function (): void {
    Route::get('/courses', [AdminController::class, 'courses'])->name('courses.index');
    Route::post('/courses', [AdminController::class, 'storeCourse'])->name('courses.store');
    Route::post('/courses/{courseId}/duplicate', [AdminController::class, 'duplicateCourse'])->name('courses.duplicate');
    Route::post('/courses/{courseId}/delete', [AdminController::class, 'deleteCourse'])->name('courses.delete');
    Route::get('/courses/{courseId}', [AdminController::class, 'editCourse'])->name('courses.show');
    Route::post('/courses/{courseId}', [AdminController::class, 'updateCourse'])->name('courses.update');
    Route::post('/courses/{courseId}/modules', [AdminController::class, 'storeModule'])->name('modules.store');
    Route::post('/modules/{moduleId}', [AdminController::class, 'updateModule'])->name('modules.update');
    Route::post('/modules/{moduleId}/delete', [AdminController::class, 'deleteModule'])->name('modules.delete');
    Route::post('/modules/{moduleId}/lessons', [AdminController::class, 'storeLesson'])->name('lessons.store');
    Route::get('/lessons/{lessonId}', [AdminController::class, 'editLesson'])->name('lessons.show');
    Route::post('/lessons/{lessonId}', [AdminController::class, 'updateLesson'])->name('lessons.update');
    Route::post('/lessons/{lessonId}/delete', [AdminController::class, 'deleteLesson'])->name('lessons.delete');
    Route::post('/lessons/{lessonId}/quiz', [AdminController::class, 'updateLessonQuiz'])->name('lessons.quiz');
    Route::post('/lessons/{lessonId}/video', [MediaController::class, 'uploadLessonVideo'])->name('lessons.video.store');
    Route::post('/lessons/{lessonId}/video/delete', [MediaController::class, 'deleteLessonVideo'])->name('lessons.video.delete');
    Route::post('/lessons/{lessonId}/attachments', [MediaController::class, 'uploadLessonAttachment'])->name('lessons.attachments.store');
    Route::post('/lessons/{lessonId}/attachments/{assetId}/delete', [MediaController::class, 'deleteLessonAttachment'])->name('lessons.attachments.delete');
    Route::get('/questions', [AdminController::class, 'questions'])->name('questions.index');
    Route::post('/questions', [AdminController::class, 'storeQuestion'])->name('questions.store');
    Route::post('/questions/{questionId}', [AdminController::class, 'updateQuestion'])->name('questions.update');
    Route::post('/questions/{questionId}/delete', [AdminController::class, 'deleteQuestion'])->name('questions.delete');
});

Route::middleware('role:ADMIN')->prefix('admin')->name('admin.')->group(function (): void {
    Route::get('/', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/course-categories', [AdminController::class, 'courseCategories'])->name('course-categories.index');
    Route::post('/course-categories', [AdminController::class, 'storeCourseCategory'])->name('course-categories.store');
    Route::post('/course-categories/{categoryId}', [AdminController::class, 'updateCourseCategory'])->name('course-categories.update');
    Route::post('/course-categories/{categoryId}/delete', [AdminController::class, 'deleteCourseCategory'])->name('course-categories.delete');
    Route::get('/knowledge-base', [AdminController::class, 'knowledgeBase'])->name('knowledge.index');
    Route::post('/knowledge-base/categories', [AdminController::class, 'storeKnowledgeCategory'])->name('knowledge.categories.store');
    Route::post('/knowledge-base/categories/{categoryId}', [AdminController::class, 'updateKnowledgeCategory'])->name('knowledge.categories.update');
    Route::post('/knowledge-base/categories/{categoryId}/delete', [AdminController::class, 'deleteKnowledgeCategory'])->name('knowledge.categories.delete');
    Route::post('/knowledge-base/articles', [AdminController::class, 'storeKnowledgeArticle'])->name('knowledge.articles.store');
    Route::get('/knowledge-base/articles/{articleId}', [AdminController::class, 'editKnowledgeArticle'])->name('knowledge.articles.show');
    Route::post('/knowledge-base/articles/{articleId}', [AdminController::class, 'updateKnowledgeArticle'])->name('knowledge.articles.update');
    Route::post('/knowledge-base/articles/{articleId}/delete', [AdminController::class, 'deleteKnowledgeArticle'])->name('knowledge.articles.delete');
    Route::get('/users', [AdminController::class, 'users'])->name('users.index');
    Route::post('/users', [AdminController::class, 'storeUser'])->name('users.store');
    Route::get('/users/{userId}', [AdminController::class, 'editUser'])->name('users.show');
    Route::post('/users/{userId}', [AdminController::class, 'updateUser'])->name('users.update');
    Route::get('/assignments', [AdminController::class, 'assignments'])->name('assignments.index');
    Route::post('/assignments', [AdminController::class, 'storeAssignment'])->name('assignments.store');
    Route::get('/results', [AdminController::class, 'results'])->name('results.index');
    Route::get('/results/{userId}', [AdminController::class, 'resultDetail'])->name('results.show');
    Route::get('/media', [AdminController::class, 'media'])->name('media.index');
    Route::post('/media/{assetId}/delete', [AdminController::class, 'deleteMedia'])->name('media.delete');
});

Route::get('/media/{assetId}', [MediaController::class, 'show'])->name('media.show');
