<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Course;
use App\Models\Professor;
use App\Models\Review;
use App\Models\Comment;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Create an admin
        $admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@gradguide.com',
            'role' => 'admin',
            'password' => bcrypt('admin123'),
        ]);

        // Create a student
        $student = User::create([
            'name' => 'Student User',
            'email' => 'student@gradguide.com',
            'role' => 'student',
            'password' => bcrypt('student123'),
        ]);

        // Create a mentor
        $mentor = User::create([
            'name' => 'Mentor User',
            'email' => 'mentor@gradguide.com',
            'role' => 'mentor',
            'password' => bcrypt('mentor123'),
        ]);

        // Create additional students for more diverse reviews
        $additionalStudents = [
            ['name' => 'Alex Johnson', 'email' => 'alex@example.com'],
            ['name' => 'Sarah Wilson', 'email' => 'sarah@example.com'],
            ['name' => 'Mike Davis', 'email' => 'mike@example.com'],
            ['name' => 'Emily Brown', 'email' => 'emily@example.com'],
            ['name' => 'David Lee', 'email' => 'david@example.com'],
            ['name' => 'Lisa Garcia', 'email' => 'lisa@example.com'],
            ['name' => 'Tom Anderson', 'email' => 'tom@example.com'],
            ['name' => 'Anna Martinez', 'email' => 'anna@example.com'],
        ];

        foreach ($additionalStudents as $studentData) {
            User::create([
                'name' => $studentData['name'],
                'email' => $studentData['email'],
                'password' => bcrypt('password'),
                'role' => 'student',
            ]);
        }

        // Create professors with more variety
        $professors = [
            ['name' => 'Dr. Sarah Williams', 'department' => 'Computer Science'],
            ['name' => 'Prof. Michael Chen', 'department' => 'Computer Science'],
            ['name' => 'Dr. Emily Rodriguez', 'department' => 'Computer Science'],
            ['name' => 'Prof. James Thompson', 'department' => 'Computer Science'],
            ['name' => 'Dr. Maria Garcia', 'department' => 'Computer Science'],
            ['name' => 'Prof. Robert Lee', 'department' => 'Computer Science'],
            ['name' => 'Dr. Jennifer Kim', 'department' => 'Computer Science'],
            ['name' => 'Prof. David Miller', 'department' => 'Computer Science'],
            ['name' => 'Dr. Amanda Foster', 'department' => 'Computer Science'],
            ['name' => 'Prof. Christopher Taylor', 'department' => 'Computer Science'],
            ['name' => 'Dr. Rachel Green', 'department' => 'Computer Science'],
            ['name' => 'Prof. Daniel White', 'department' => 'Computer Science'],
            ['name' => 'Dr. Jessica Black', 'department' => 'Computer Science'],
            ['name' => 'Prof. Kevin Brown', 'department' => 'Computer Science'],
            ['name' => 'Dr. Nicole Davis', 'department' => 'Computer Science'],
            ['name' => 'Prof. Steven Wilson', 'department' => 'Computer Science'],
        ];

        foreach ($professors as $profData) {
            Professor::create($profData);
        }

        // Create courses with more variety
        $courses = [
            ['name' => 'Web Development Fundamentals', 'code' => 'CS101', 'department' => 'Computer Science'],
            ['name' => 'Advanced Web Technologies', 'code' => 'CS201', 'department' => 'Computer Science'],
            ['name' => 'Web Tech II', 'code' => 'CS301', 'department' => 'Computer Science'],
            ['name' => 'Database Systems', 'code' => 'CS401', 'department' => 'Computer Science'],
            ['name' => 'Software Engineering', 'code' => 'CS501', 'department' => 'Computer Science'],
            ['name' => 'Data Structures', 'code' => 'CS601', 'department' => 'Computer Science'],
            ['name' => 'Algorithms', 'code' => 'CS701', 'department' => 'Computer Science'],
            ['name' => 'Machine Learning', 'code' => 'CS801', 'department' => 'Computer Science'],
            ['name' => 'Computer Networks', 'code' => 'CS901', 'department' => 'Computer Science'],
            ['name' => 'Operating Systems', 'code' => 'CS1001', 'department' => 'Computer Science'],
            ['name' => 'Artificial Intelligence', 'code' => 'CS1101', 'department' => 'Computer Science'],
            ['name' => 'Cybersecurity', 'code' => 'CS1201', 'department' => 'Computer Science'],
            ['name' => 'Mobile App Development', 'code' => 'CS1301', 'department' => 'Computer Science'],
            ['name' => 'Cloud Computing', 'code' => 'CS1401', 'department' => 'Computer Science'],
            ['name' => 'Big Data Analytics', 'code' => 'CS1501', 'department' => 'Computer Science'],
            ['name' => 'Game Development', 'code' => 'CS1601', 'department' => 'Computer Science'],
        ];

        foreach ($courses as $courseData) {
            Course::create($courseData);
        }

        // Get all users, professors, and courses for creating reviews
        $allUsers = User::where('role', 'student')->get();
        $allProfessors = Professor::all();
        $allCourses = Course::all();

        // Create reviews with realistic content
        $reviewContents = [
            "This course was really challenging but very rewarding. The professor explained complex concepts clearly and was always available for help. The projects were practical and helped me understand real-world applications.",
            "Great course! The professor is very knowledgeable and passionate about the subject. The assignments were well-structured and the feedback was constructive. Highly recommend!",
            "The course content was interesting but the workload was quite heavy. The professor was helpful but sometimes moved too fast through the material. Overall, it was a good learning experience.",
            "Excellent course with a fantastic professor. The lectures were engaging and the practical exercises really helped solidify the concepts. The professor was very approachable and always willing to help.",
            "This was one of the most challenging courses I've taken, but also one of the most valuable. The professor pushed us to think critically and the projects were very practical.",
            "The course was well-organized and the professor was very clear in their explanations. The assignments were relevant and helped me understand the material better.",
            "Good course overall. The professor was knowledgeable and the content was relevant. Some assignments were a bit confusing but the professor was always available to clarify.",
            "This course exceeded my expectations. The professor was excellent and the material was presented in a way that was easy to understand. The projects were challenging but rewarding.",
            "The course was interesting but quite difficult. The professor was helpful but sometimes the pace was too fast. The assignments were practical and relevant.",
            "Amazing course! The professor is one of the best I've had. Clear explanations, practical examples, and great support throughout the semester.",
            "The course was challenging but fair. The professor was very knowledgeable and always willing to help. The assignments were well-designed and helped reinforce the concepts.",
            "Good course with a solid professor. The material was presented clearly and the assignments were practical. Would recommend to other students.",
            "This course was quite difficult but very informative. The professor was helpful and the content was relevant to current industry practices.",
            "Excellent course! The professor was very engaging and the material was presented in an interesting way. The projects were challenging but helped me learn a lot.",
            "The course was well-structured and the professor was very clear in their explanations. The assignments were practical and helped me understand the concepts better.",
            "This was a great course with an excellent professor. The material was challenging but the professor made it accessible. Highly recommend!",
            "The professor's teaching style really clicked with me. The course material was presented in a logical way and the examples were very helpful.",
            "I found this course to be quite challenging initially, but the professor's office hours were incredibly helpful. The projects were interesting and relevant.",
            "The course content was excellent and the professor was very knowledgeable. However, the workload was quite heavy and some students struggled to keep up.",
            "This professor has a unique way of explaining complex topics that makes them easy to understand. The course was well-paced and the assignments were fair.",
            "The course was well-designed with a good balance of theory and practical work. The professor was always available for questions and provided helpful feedback.",
            "I really enjoyed this course. The professor was passionate about the subject and it showed in their teaching. The assignments were challenging but rewarding.",
            "The course material was comprehensive and the professor was very organized. The lectures were engaging and the practical exercises were well-designed.",
            "This course provided a solid foundation in the subject. The professor was knowledgeable and the assignments helped reinforce the concepts well.",
            "The professor's enthusiasm for the subject was contagious. The course was well-structured and the projects were interesting and relevant to real-world applications.",
            "I learned a lot in this course. The professor was very clear in their explanations and the assignments were well-designed to help us understand the material.",
            "The course was challenging but the professor provided excellent support. The material was presented in a logical way and the examples were very helpful.",
            "This professor really knows how to engage students. The course was interesting and the assignments were practical and relevant to what we might encounter in the field.",
        ];

        $ratings = [1, 2, 3, 4, 5]; // Include some lower ratings for realism

        // Create reviews
        for ($i = 0; $i < 25; $i++) {
            $user = $allUsers->random();
            $professor = $allProfessors->random();
            $course = $allCourses->random();
            $content = $reviewContents[array_rand($reviewContents)];
            $rating = $ratings[array_rand($ratings)];

            $review = Review::create([
                'user_id' => $user->id,
                'professor_id' => $professor->id,
                'course_id' => $course->id,
                'rating' => $rating,
                'content' => $content,
                'helpful_votes' => rand(0, 20),
                'created_at' => now()->subDays(rand(1, 60)),
            ]);

            // Create some comments for reviews
            $otherUsers = $allUsers->where('id', '!=', $user->id);
            $maxComments = min($otherUsers->count(), rand(0, 3));
            if ($maxComments > 0) {
                $commentUsers = $otherUsers->random($maxComments);
                foreach ($commentUsers as $commentUser) {
                    $commentContents = [
                        "Great review! I had a similar experience.",
                        "Thanks for sharing your thoughts on this course.",
                        "I'm taking this course next semester, this is helpful!",
                        "I agree with your assessment of the professor.",
                        "The workload was indeed challenging but worth it.",
                        "Thanks for the detailed review!",
                        "I had a different experience but appreciate your perspective.",
                        "This review is spot on!",
                        "Very helpful review, thanks for sharing!",
                        "I'm considering this course, your review helps a lot.",
                        "Good points about the professor's teaching style.",
                        "The projects were indeed challenging but educational.",
                        "Thanks for the honest feedback!",
                        "This matches my experience with the course.",
                        "Helpful insights about the workload and content.",
                    ];

                    Comment::create([
                        'user_id' => $commentUser->id,
                        'review_id' => $review->id,
                        'content' => $commentContents[array_rand($commentContents)],
                        'created_at' => $review->created_at->addDays(rand(1, 14)),
                    ]);
                }
            }
        }
        
        // Call the ReviewSeeder to add more reviews
        $this->call(ReviewSeeder::class);
    }
}
