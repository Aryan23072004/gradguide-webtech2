<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Review;
use App\Models\Course;
use App\Models\Professor;
use App\Models\User;

class ReviewSeeder extends Seeder
{
    public function run(): void
    {
        \DB::table('reviews')->delete(); // safer than truncate

        $courses = Course::all();
        $professors = Professor::all();
        $users = User::where('role', 'student')->get();

        if ($courses->isEmpty() || $professors->isEmpty() || $users->isEmpty()) {
            return; // Don't seed if no courses, professors, or users exist
        }

        $reviewContents = [
            // Positive reviews
            "Excellent professor! Very knowledgeable and explains complex concepts clearly. The course was challenging but fair, and I learned a lot. Highly recommend!",
            "One of the best professors I've had. Engaging lectures, helpful office hours, and practical assignments. The material was presented in an interesting way.",
            "Great teaching style and very approachable. The professor was always willing to help and provided constructive feedback on assignments.",
            "Amazing course with a fantastic professor. Clear explanations, relevant examples, and the projects were very practical and educational.",
            "This professor really knows how to engage students. The course was well-structured and the assignments helped reinforce the concepts effectively.",
            "Outstanding professor with a passion for teaching. The course content was comprehensive and the professor made difficult topics accessible.",
            "Very knowledgeable professor who explains things clearly. The course was well-organized and the assignments were relevant to real-world applications.",
            "Excellent professor! The lectures were engaging and the professor was always available for questions. The course exceeded my expectations.",
            "Great professor with a clear teaching style. The material was presented logically and the examples were very helpful for understanding concepts.",
            "This professor is one of the best in the department. Very knowledgeable, helpful, and the course was well-designed with practical applications.",
            
            // Good reviews
            "Good professor overall. The course was informative and the professor was helpful when needed. Some assignments were challenging but educational.",
            "Solid professor with good knowledge of the subject. The course was well-structured and the professor was approachable for questions.",
            "Decent professor who covers the material well. The course was interesting and the professor was generally helpful during office hours.",
            "Good course with a competent professor. The material was presented clearly and the assignments were reasonable and educational.",
            "Fair professor who teaches the material effectively. The course was well-organized and the professor was available for help when needed.",
            "Competent professor with good knowledge of the subject. The course was informative and the professor was helpful for clarification.",
            "Good professor overall. The course content was relevant and the professor was approachable for questions and concerns.",
            "Decent professor who explains concepts well. The course was structured logically and the professor was helpful during office hours.",
            "Fair professor with good teaching abilities. The course was educational and the professor was willing to help students who struggled.",
            "Good professor who covers the material thoroughly. The course was well-designed and the professor was accessible for questions.",
            
            // Mixed reviews
            "The professor is knowledgeable but sometimes moves too fast through the material. The course was challenging but educational. Office hours were helpful.",
            "Good professor but the course workload was quite heavy. The material was interesting but some assignments were confusing. Overall, it was a learning experience.",
            "The professor knows the subject well but the teaching style could be improved. The course was informative but sometimes difficult to follow.",
            "Competent professor but the course structure could be better. The material was relevant but some lectures were hard to understand.",
            "The professor is helpful but the course was more challenging than expected. The material was comprehensive but the pace was sometimes too fast.",
            "Good professor overall but the course was quite demanding. The material was interesting but some concepts were difficult to grasp initially.",
            "The professor is knowledgeable but the course organization could be improved. The material was relevant but some assignments were unclear.",
            "Fair professor but the course was more difficult than anticipated. The material was educational but the workload was heavy.",
            "The professor is approachable but the course structure was confusing at times. The material was informative but some lectures were hard to follow.",
            "Good professor but the course was challenging. The material was relevant but some assignments were more difficult than expected.",
            
            // Critical reviews
            "The professor is knowledgeable but the teaching style is not very effective. The course was difficult to follow and some assignments were unclear.",
            "The course was challenging but the professor could have been more helpful. The material was interesting but the pace was too fast for most students.",
            "The professor knows the subject but the course organization was poor. The material was relevant but the assignments were confusing and unclear.",
            "The course was informative but the professor's teaching style made it difficult to learn. Some concepts were not explained clearly enough.",
            "The course was interesting but the professor could have been more supportive. The material was relevant but some assignments were too difficult.",
            "The professor has knowledge but the teaching approach could be improved. The course was educational but sometimes hard to understand.",
            "The course was comprehensive but the professor's communication could be better. The material was relevant but some lectures were confusing.",
            "The professor is knowledgeable but the course organization was lacking. The material was informative but the assignments were not well-explained.",
            "The course was challenging but the professor could have provided more guidance. The material was educational but the pace was too fast.",
            
            // Very positive reviews
            "Absolutely outstanding professor! The best I've had in my academic career. Clear explanations, engaging lectures, and incredibly helpful. The course was challenging but incredibly rewarding.",
            "Exceptional professor with an amazing teaching style. The course was perfectly structured and the professor went above and beyond to help students succeed.",
            "Incredible professor who makes learning enjoyable. The course was well-designed with practical applications and the professor was always available for support.",
            "Fantastic professor with a passion for teaching. The course exceeded all expectations and the professor's enthusiasm was contagious.",
            "Remarkable professor who truly cares about student success. The course was comprehensive and the professor provided excellent guidance throughout.",
            "Extraordinary professor with exceptional knowledge and teaching abilities. The course was perfectly balanced and the professor was incredibly supportive.",
            "Amazing professor who makes complex topics accessible. The course was well-organized and the professor's teaching style was perfect for the subject.",
            "Outstanding professor with excellent communication skills. The course was engaging and the professor was always willing to go the extra mile.",
            "Exceptional professor who creates an excellent learning environment. The course was comprehensive and the professor's expertise was evident throughout.",
            "Incredible professor with a gift for teaching. The course was perfectly structured and the professor's dedication to student success was remarkable.",
        ];

        $ratings = [1, 2, 3, 4, 5]; // Include all ratings for realism

        // Create 55+ reviews
        for ($i = 0; $i < 55; $i++) {
            $user = $users->random();
            $professor = $professors->random();
            $course = $courses->random();
            $content = $reviewContents[array_rand($reviewContents)];
            $rating = $ratings[array_rand($ratings)];

            $review = Review::create([
                'user_id' => $user->id,
                'professor_id' => $professor->id,
                'course_id' => $course->id,
                'rating' => $rating,
                'content' => $content,
                'helpful_votes' => rand(0, 25),
                'created_at' => now()->subDays(rand(1, 90)),
            ]);
        }

        echo "✅ Created " . Review::count() . " reviews successfully!\n";
    }
} 