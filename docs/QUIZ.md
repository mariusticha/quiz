# German Politicians Quiz Application

This Laravel application is a quiz game about the German cabinet (Kabinett Merz) as of May 6, 2025. The quiz is designed to help users learn about German politicians through various question types and interactive elements.

## Features

- Dynamic question generation with randomized question types
- One question per politician to maintain variety
- Image-based questions for visual recognition
- Progress tracking and scoring system
- Dark mode support
- Responsive design for mobile and desktop

## Question Types

### 1. Text-Based Questions

- **Job Questions**
  - Format: "What is [Politician's Name]'s job?"
  - Always available for all politicians
  - Options: 4 unique job titles (or fewer if not enough unique options available)

- **Party Questions**
  - Format: "Which political party does [Politician's Name] belong to?"
  - Available when there are multiple unique parties
  - Options: All unique political parties (CDU, CSU, SPD)

### 2. Image-Based Questions

Available for politicians who have associated images:

- **Image Selection**
  - Format: "Select the image of [Politician's Name]"
  - Shows: Multiple politician images
  - Task: Select the correct image matching the name

- **Person Identification**
  - Format: "Who is this person?"
  - Shows: Single politician image
  - Task: Select the correct name from options

- **Job Identification**
  - Format: "What is the role of the person in this image?"
  - Shows: Single politician image
  - Task: Select the correct job title from options

## Technical Implementation

### Database Structure

- `persons` table stores politician information:
  - name
  - job
  - birth_date
  - political_party
  - image_path

- `quiz_attempts` table tracks user performance:
  - user_id
  - correct_answers
  - total_questions
  - time_taken_seconds
  - questions_data (JSON)
  - completed_at

### Key Components

1. **Quiz Component** (`app/Livewire/Quiz.php`)
   - Handles question generation and game logic
   - Manages user progression through questions
   - Records quiz attempts and scores

2. **Image Management**
   - Images stored in `public/storage/politicians/`
   - Consistent naming convention: lowercase-hyphenated-names.jpg
   - Backup system for original images

### Question Generation Logic

1. One question per politician to ensure coverage
2. Random selection of question type from available options
3. Smart option generation:
   - Ensures unique options
   - Adapts to available unique choices
   - Maximum of 4 options per question
   - Minimum of 2 options for valid questions

## User Experience

- Progress indicator showing current question number
- Previous/Next navigation
- Error prevention for unanswered questions
- Comprehensive results page showing:
  - Total score
  - Time taken
  - Detailed review of each question
  - Visual feedback for correct/incorrect answers

## Data Sources

The quiz uses real German politicians from the Kabinett Merz (as of May 6, 2025), including:
- Chancellor Friedrich Merz
- Vice Chancellor Lars Klingbeil
- Various ministers and cabinet members
- Images sourced from reliable media outlets

## Future Improvements

Potential areas for enhancement:
1. Additional question types (e.g., birth dates, career history)
2. Difficulty levels
3. Specialized quiz modes (party-specific, role-specific)
4. Statistical analysis of user performance
5. Learning mode with additional information
6. Spaced repetition for frequently missed questions

## Technical Requirements

- PHP 8.x
- Laravel 10.x
- MySQL/MariaDB
- Livewire for interactive components
- Storage configuration for images
- Web server with PHP support
