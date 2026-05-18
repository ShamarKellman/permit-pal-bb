<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Answer;
use App\Models\Category;
use App\Models\Question;
use Illuminate\Database\Seeder;

class QuestionSeeder extends Seeder
{
    public function run(): void
    {
        $data = $this->questions();

        foreach ($data as $item) {
            $category = Category::query()->where('slug', $item['category'])->first();

            if (! $category) {
                continue;
            }

            $question = Question::query()->updateOrCreate(
                ['question_text' => $item['question']],
                [
                    'category_id' => $category->id,
                    'difficulty' => $item['difficulty'],
                    'image_path' => $item['image'] ?? null,
                    'is_active' => true,
                ]
            );

            // Remove existing answers before re-seeding to avoid duplicates
            $question->answers()->delete();

            foreach ($item['answers'] as $answerData) {
                Answer::query()->create([
                    'question_id' => $question->id,
                    'answer_text' => $answerData['text'],
                    'is_correct' => $answerData['correct'],
                    'explanation' => $answerData['explanation'] ?? null,
                ]);
            }
        }
    }

    /** @return array<int, array{
     *     category: string,
     *     difficulty: string,
     *     question: string,
     *     answers: array<int,
     *          array{
     *              text: string,
     *              correct: bool,
     *              explanation?: string
     *          }>,
     *     image?: string
     * }>
     */
    private function questions(): array
    {
        return [

            // -------------------------------------------------------
            // ROAD SIGNS
            // -------------------------------------------------------
            [
                'category' => 'road-signs',
                'difficulty' => 'easy',
                'question' => 'What shape are warning signs in Barbados?',
                'answers' => [
                    ['text' => 'Circular',   'correct' => false, 'explanation' => 'Circular signs give orders or prohibitions.'],
                    ['text' => 'Triangular', 'correct' => true,  'explanation' => 'Triangular signs warn drivers of hazards ahead.'],
                    ['text' => 'Rectangular', 'correct' => false, 'explanation' => 'Rectangular signs are generally informational or directional.'],
                    ['text' => 'Octagonal',  'correct' => false, 'explanation' => 'The octagonal shape is reserved for STOP signs only.'],
                ],
            ],
            [
                'category' => 'road-signs',
                'difficulty' => 'easy',
                'question' => 'What shape is a STOP sign?',
                'answers' => [
                    ['text' => 'Triangular', 'correct' => false, 'explanation' => 'Triangular signs are warning signs.'],
                    ['text' => 'Circular',   'correct' => false, 'explanation' => 'Circular signs give orders or prohibitions.'],
                    ['text' => 'Octagonal',  'correct' => true,  'explanation' => 'The STOP sign is the only octagonal road sign.'],
                    ['text' => 'Rectangular', 'correct' => false, 'explanation' => 'Rectangular signs are informational or directional.'],
                ],
            ],
            [
                'category' => 'road-signs',
                'difficulty' => 'easy',
                'question' => 'What does a red circular road sign with a white horizontal bar in the middle mean?',
                'answers' => [
                    ['text' => 'Give way',    'correct' => false, 'explanation' => 'Give way signs are triangular and inverted.'],
                    ['text' => 'No entry',    'correct' => true,  'explanation' => 'A red circle with a white horizontal bar means no entry — vehicles must not enter.'],
                    ['text' => 'No overtaking', 'correct' => false, 'explanation' => 'No overtaking signs show two cars side by side.'],
                    ['text' => 'Speed limit', 'correct' => false, 'explanation' => 'Speed limit signs show a number inside a red circle.'],
                ],
            ],
            [
                'category' => 'road-signs',
                'difficulty' => 'medium',
                'question' => 'A circular sign with a red border and white background showing a bicycle and a car means what?',
                'answers' => [
                    ['text' => 'Cycles and cars only',         'correct' => false, 'explanation' => 'This is not a permitted vehicles sign.'],
                    ['text' => 'All vehicles are prohibited',  'correct' => true,  'explanation' => 'This sign prohibits all motor vehicles from entering.'],
                    ['text' => 'Watch out for cycles and cars', 'correct' => false, 'explanation' => 'Warning signs are triangular, not circular.'],
                    ['text' => 'Cycles prohibited',            'correct' => false, 'explanation' => 'A cycles-only prohibition would show just a bicycle.'],
                ],
            ],
            [
                'category' => 'road-signs',
                'difficulty' => 'easy',
                'question' => 'What does a circular sign with three arrows going in a circle indicate?',
                'answers' => [
                    ['text' => 'A roundabout',      'correct' => false, 'explanation' => 'A roundabout warning sign is triangular.'],
                    ['text' => 'A mini-roundabout', 'correct' => true,  'explanation' => 'A circular sign with three circling arrows marks a mini-roundabout.'],
                    ['text' => 'A ring road',        'correct' => false, 'explanation' => 'Ring road signs are rectangular and directional.'],
                    ['text' => 'A one-way system',   'correct' => false, 'explanation' => 'One-way signs use a single directional arrow.'],
                ],
            ],
            [
                'category' => 'road-signs',
                'difficulty' => 'easy',
                'question' => 'Where would you find directional signs with a green background in Barbados?',
                'answers' => [
                    ['text' => 'On minor roads',  'correct' => false, 'explanation' => 'Minor road signs typically have a white or blue background.'],
                    ['text' => 'At crossroads',   'correct' => false, 'explanation' => 'Green background signs are not specific to crossroads.'],
                    ['text' => 'On the highway',  'correct' => true,  'explanation' => 'Green background directional signs are found on highways.'],
                    ['text' => 'In car parks',    'correct' => false, 'explanation' => 'Car park signs are typically blue or white.'],
                ],
            ],
            [
                'category' => 'road-signs',
                'difficulty' => 'easy',
                'question' => 'What is the most common traffic sign found on roads in Barbados?',
                'answers' => [
                    ['text' => 'Give way signs',    'correct' => false, 'explanation' => 'Give way signs are common but not the most frequent.'],
                    ['text' => 'Rectangular signs', 'correct' => false, 'explanation' => 'Rectangular signs are informational but not the most common.'],
                    ['text' => 'Cat eyes',          'correct' => true,  'explanation' => 'Cat eyes (road reflectors) are the most commonly encountered road markings/signs.'],
                    ['text' => 'Speed limit signs', 'correct' => false, 'explanation' => 'Speed limit signs are common but not the most frequent.'],
                ],
            ],
            [
                'category' => 'road-signs',
                'difficulty' => 'medium',
                'question' => 'A triangular sign with a white background, red border and a single pedestrian walking means what?',
                'answers' => [
                    ['text' => 'Pedestrians only ahead',     'correct' => false, 'explanation' => 'This would be a regulatory sign, not a warning.'],
                    ['text' => 'Pedestrian crossing ahead',  'correct' => true,  'explanation' => 'A triangular sign with a pedestrian warns of a crossing ahead.'],
                    ['text' => 'School crossing ahead',      'correct' => false, 'explanation' => 'A school crossing sign typically shows two figures (adult and child).'],
                    ['text' => 'No pedestrians allowed',     'correct' => false, 'explanation' => 'A prohibition sign would be circular with a red border.'],
                ],
            ],
            [
                'category' => 'road-signs',
                'difficulty' => 'easy',
                'question' => 'What shape are most directional signs?',
                'answers' => [
                    ['text' => 'Triangular',  'correct' => false, 'explanation' => 'Triangular signs are warning signs.'],
                    ['text' => 'Circular',    'correct' => false, 'explanation' => 'Circular signs give orders.'],
                    ['text' => 'Octagonal',   'correct' => false, 'explanation' => 'Octagonal is reserved for STOP signs.'],
                    ['text' => 'Rectangular', 'correct' => true,  'explanation' => 'Directional and informational signs are mostly rectangular.'],
                ],
            ],
            [
                'category' => 'road-signs',
                'difficulty' => 'medium',
                'question' => 'What does a sign with an "H" on it represent?',
                'answers' => [
                    ['text' => 'Highway entrance', 'correct' => false, 'explanation' => 'Highway entrances use directional signs.'],
                    ['text' => 'Hydrant',           'correct' => true,  'explanation' => 'An "H" sign marks the location of a fire hydrant.'],
                    ['text' => 'Hospital',          'correct' => false, 'explanation' => 'Hospital signs typically show an "H" in a blue square, not a standalone roadside sign.'],
                    ['text' => 'Halt point',        'correct' => false, 'explanation' => 'There is no standard halt-point sign with an H.'],
                ],
            ],

            // -------------------------------------------------------
            // TRAFFIC LIGHTS & SIGNALS
            // -------------------------------------------------------
            [
                'category' => 'traffic-lights-signals',
                'difficulty' => 'easy',
                'question' => 'At a junction controlled by traffic lights, where must vehicles stop?',
                'answers' => [
                    ['text' => 'Before the junction entrance',   'correct' => false, 'explanation' => 'Vehicles must stop at the marked stop line, not before the junction.'],
                    ['text' => 'At the stop line',               'correct' => true,  'explanation' => 'Vehicles must stop at the white stop line at traffic lights.'],
                    ['text' => 'In the middle of the junction',  'correct' => false, 'explanation' => 'Stopping in the junction blocks other road users.'],
                    ['text' => 'Past the stop line if clear',    'correct' => false, 'explanation' => 'You must stop at the stop line regardless.'],
                ],
            ],
            [
                'category' => 'traffic-lights-signals',
                'difficulty' => 'easy',
                'question' => 'What does an amber traffic light on its own mean?',
                'answers' => [
                    ['text' => 'Proceed with caution',           'correct' => false, 'explanation' => 'Amber does not mean proceed — it means prepare to stop.'],
                    ['text' => 'Stop unless unsafe to do so',    'correct' => true,  'explanation' => 'Amber means stop at the line unless you are so close that stopping would cause a collision.'],
                    ['text' => 'The light is about to turn green', 'correct' => false, 'explanation' => 'Amber after red means prepare to go, but amber alone means stop.'],
                    ['text' => 'Speed up to clear the junction', 'correct' => false, 'explanation' => 'Speeding up at an amber light is dangerous and illegal.'],
                ],
            ],
            [
                'category' => 'traffic-lights-signals',
                'difficulty' => 'medium',
                'question' => 'Which hand signals are included in the Barbados Highway Code?',
                'answers' => [
                    ['text' => 'Speeding up and braking only',                                    'correct' => false, 'explanation' => 'These are not the defined hand signals.'],
                    ['text' => 'Moving off, slowing down, turning left and turning right',        'correct' => true,  'explanation' => 'The Highway Code specifies these four hand signals for drivers.'],
                    ['text' => 'Turning left and turning right only',                             'correct' => false, 'explanation' => 'There are more than two hand signals in the code.'],
                    ['text' => 'Slowing down, stopping, turning left and hazard warning',         'correct' => false, 'explanation' => 'Hazard warning is not a defined hand signal.'],
                ],
            ],
            [
                'category' => 'traffic-lights-signals',
                'difficulty' => 'easy',
                'question' => 'Signals on the road include road markings, traffic lights and what else?',
                'answers' => [
                    ['text' => 'Speed cameras',                    'correct' => false, 'explanation' => 'Speed cameras are enforcement devices, not signals.'],
                    ['text' => 'Signals from police officers and wardens', 'correct' => true,  'explanation' => 'Police officers, traffic wardens and school wardens also give signals to road users.'],
                    ['text' => 'Car horns',                        'correct' => false, 'explanation' => 'Horns are warning devices, not official road signals.'],
                    ['text' => 'Reflective road studs only',       'correct' => false, 'explanation' => 'Road studs are markings, not signals.'],
                ],
            ],
            [
                'category' => 'traffic-lights-signals',
                'difficulty' => 'medium',
                'question' => 'A police car is following you. The officer flashes the headlights and points to the left. What should you do?',
                'answers' => [
                    ['text' => 'Stop immediately in the lane',    'correct' => false, 'explanation' => 'Stopping suddenly in your lane could cause an accident.'],
                    ['text' => 'Ignore it and continue driving',  'correct' => false, 'explanation' => 'You must comply with signals from police officers.'],
                    ['text' => 'Pull up on the left',             'correct' => true,  'explanation' => 'The officer is signalling you to pull over to the left side of the road safely.'],
                    ['text' => 'Turn left at the next junction',  'correct' => false, 'explanation' => 'You should pull over immediately, not wait for a junction.'],
                ],
            ],

            // -------------------------------------------------------
            // SPEED LIMITS
            // -------------------------------------------------------
            [
                'category' => 'speed-limits',
                'difficulty' => 'easy',
                'question' => 'Unless a sign shows otherwise, what is the default speed limit in Barbados?',
                'answers' => [
                    ['text' => '40 km/h', 'correct' => false, 'explanation' => '40 km/h is the limit in city/urban areas.'],
                    ['text' => '80 km/h', 'correct' => false, 'explanation' => '80 km/h is the highway speed limit.'],
                    ['text' => '60 km/h', 'correct' => true,  'explanation' => 'The default speed limit where no sign is posted is 60 km/h.'],
                    ['text' => '50 km/h', 'correct' => false, 'explanation' => '50 km/h is not a standard posted limit in Barbados.'],
                ],
            ],
            [
                'category' => 'speed-limits',
                'difficulty' => 'easy',
                'question' => 'What is the speed limit in city and urban areas in Barbados?',
                'answers' => [
                    ['text' => '60 km/h', 'correct' => false, 'explanation' => '60 km/h is the default rural road limit.'],
                    ['text' => '80 km/h', 'correct' => false, 'explanation' => '80 km/h is the highway limit.'],
                    ['text' => '30 km/h', 'correct' => false, 'explanation' => '30 km/h is not a standard posted urban limit.'],
                    ['text' => '40 km/h', 'correct' => true,  'explanation' => 'The speed limit in city and urban areas is 40 km/h.'],
                ],
            ],
            [
                'category' => 'speed-limits',
                'difficulty' => 'medium',
                'question' => 'What is the speed limit on major highways in Barbados?',
                'answers' => [
                    ['text' => '60 km/h', 'correct' => false, 'explanation' => '60 km/h is the default rural road limit.'],
                    ['text' => '100 km/h', 'correct' => false, 'explanation' => 'There is no 100 km/h limit in Barbados.'],
                    ['text' => '80 km/h', 'correct' => true,  'explanation' => 'The speed limit on major highways in Barbados is 80 km/h.'],
                    ['text' => '70 km/h', 'correct' => false, 'explanation' => '70 km/h is not a standard posted limit in Barbados.'],
                ],
            ],
            [
                'category' => 'speed-limits',
                'difficulty' => 'medium',
                'question' => 'When you see a temporary speed limit sign at roadworks, you must:',
                'answers' => [
                    ['text' => 'Comply only when workers are visible',    'correct' => false, 'explanation' => 'You must comply with the sign at all times, regardless of whether workers are present.'],
                    ['text' => 'Comply with the sign at all times',       'correct' => true,  'explanation' => 'A temporary speed limit sign at roadworks must be obeyed at all times.'],
                    ['text' => 'Comply only during hours of darkness',    'correct' => false, 'explanation' => 'The sign applies during all hours, not just at night.'],
                    ['text' => 'Comply only when lanes are narrowed',     'correct' => false, 'explanation' => 'The sign applies from the point it is displayed.'],
                ],
            ],
            [
                'category' => 'speed-limits',
                'difficulty' => 'medium',
                'question' => 'Even when a speed limit is posted, can you always drive at that speed?',
                'answers' => [
                    ['text' => 'Yes, the limit is always safe to drive at',          'correct' => false, 'explanation' => 'Speed limits are maximums, not targets.'],
                    ['text' => 'No, you must drive to the conditions of the road',   'correct' => true,  'explanation' => 'The speed limit is a maximum. You must reduce speed in bad weather, poor visibility or heavy traffic.'],
                    ['text' => 'Yes, as long as there is no traffic',               'correct' => false, 'explanation' => 'Road conditions, weather and visibility also determine a safe speed.'],
                    ['text' => 'Only on highways is the limit always safe',          'correct' => false, 'explanation' => 'This is incorrect — conditions must always be considered.'],
                ],
            ],

            // -------------------------------------------------------
            // ROUNDABOUTS & JUNCTIONS
            // -------------------------------------------------------
            [
                'category' => 'roundabouts-junctions',
                'difficulty' => 'easy',
                'question' => 'At a roundabout, who should you give way to?',
                'answers' => [
                    ['text' => 'Vehicles on your left',             'correct' => false, 'explanation' => 'In Barbados traffic flows on the left, so you give way to the right.'],
                    ['text' => 'Vehicles on your right',            'correct' => true,  'explanation' => 'At a roundabout you must give way to vehicles already on the roundabout, coming from your right.'],
                    ['text' => 'Vehicles directly opposite you',    'correct' => false, 'explanation' => 'You give way to traffic from your right at all times on a roundabout.'],
                    ['text' => 'No one — first come first served',  'correct' => false, 'explanation' => 'There are clear right-of-way rules at roundabouts.'],
                ],
            ],
            [
                'category' => 'roundabouts-junctions',
                'difficulty' => 'easy',
                'question' => 'If you are at a roundabout and want to turn right, which lane should you use?',
                'answers' => [
                    ['text' => 'Any lane',   'correct' => false, 'explanation' => 'Lane discipline is important at roundabouts for safety.'],
                    ['text' => 'Left lane',  'correct' => false, 'explanation' => 'The left lane is for exits straight ahead or to the left.'],
                    ['text' => 'Right lane', 'correct' => true,  'explanation' => 'When turning right at a roundabout, you should be in the right lane.'],
                    ['text' => 'Middle lane', 'correct' => false, 'explanation' => 'There is no middle-lane rule for roundabouts in Barbados.'],
                ],
            ],
            [
                'category' => 'roundabouts-junctions',
                'difficulty' => 'medium',
                'question' => 'You are at a crossroads. The driver on the opposite side also wants to turn right. How should you position your vehicle?',
                'answers' => [
                    ['text' => 'Turn in front of the other driver',          'correct' => false, 'explanation' => 'Turning in front creates a blind spot and is dangerous.'],
                    ['text' => 'Turn behind the other driver',               'correct' => true,  'explanation' => 'When both drivers want to turn right, you should pass behind each other (offside to offside) for better visibility.'],
                    ['text' => 'Stop and wait for the other driver to go',   'correct' => false, 'explanation' => 'Both can proceed simultaneously using correct positioning.'],
                    ['text' => 'Turn at the next junction instead',          'correct' => false, 'explanation' => 'There is a safe procedure for this situation at the same junction.'],
                ],
            ],
            [
                'category' => 'roundabouts-junctions',
                'difficulty' => 'medium',
                'question' => 'You are approaching a junction and a cyclist is waiting there. What should you do?',
                'answers' => [
                    ['text' => 'Sound your horn to warn the cyclist',   'correct' => false, 'explanation' => 'Using your horn aggressively is not the correct response.'],
                    ['text' => 'Overtake the cyclist quickly',          'correct' => false, 'explanation' => 'Overtaking at a junction is dangerous.'],
                    ['text' => 'Wait until the cyclist moves',          'correct' => true,  'explanation' => 'You should wait and give the cyclist time and space to move safely.'],
                    ['text' => 'Proceed — cyclists must give way',      'correct' => false, 'explanation' => 'Cyclists have the same road rights as other vehicles.'],
                ],
            ],
            [
                'category' => 'roundabouts-junctions',
                'difficulty' => 'medium',
                'question' => 'At a STOP sign at a junction, what must you do?',
                'answers' => [
                    ['text' => 'Slow down and proceed if clear',        'correct' => false, 'explanation' => 'A STOP sign requires a complete stop, not just slowing down.'],
                    ['text' => 'Stop completely every time, then go when safe', 'correct' => true, 'explanation' => 'At a STOP sign you must come to a complete stop every time, then wait for a safe gap.'],
                    ['text' => 'Stop only if there is traffic present', 'correct' => false, 'explanation' => 'You must stop every time regardless of whether traffic is visible.'],
                    ['text' => 'Proceed — the sign is advisory only',   'correct' => false, 'explanation' => 'A STOP sign is a legal requirement, not advisory.'],
                ],
            ],

            // -------------------------------------------------------
            // OVERTAKING
            // -------------------------------------------------------
            [
                'category' => 'overtaking',
                'difficulty' => 'medium',
                'question' => 'You are about to overtake. You check your mirrors, signal and begin to manoeuvre. What important check did you miss?',
                'answers' => [
                    ['text' => 'Checking the road behind is clear',       'correct' => false, 'explanation' => 'That was already done — the missing check is ahead.'],
                    ['text' => 'Checking the road ahead is clear',        'correct' => true,  'explanation' => 'Before overtaking you must check the road ahead is clear and you have enough distance to complete the manoeuvre safely.'],
                    ['text' => 'Checking your tyre pressure',             'correct' => false, 'explanation' => 'Tyre pressure is not an overtaking check.'],
                    ['text' => 'Turning on your hazard lights',           'correct' => false, 'explanation' => 'Hazard lights are not used when overtaking.'],
                ],
            ],
            [
                'category' => 'overtaking',
                'difficulty' => 'easy',
                'question' => 'When overtaking a cyclist, motorcyclist or donkey cart, what distance should you leave?',
                'answers' => [
                    ['text' => 'Half a car length', 'correct' => false, 'explanation' => 'Half a car length is not sufficient clearance.'],
                    ['text' => '1 car length',       'correct' => true,  'explanation' => 'You should leave at least 1 car length of space when overtaking cyclists, motorcyclists or donkey carts.'],
                    ['text' => '2 car lengths',      'correct' => false, 'explanation' => 'While more space is safer, the minimum specified is 1 car length.'],
                    ['text' => '5 metres',           'correct' => false, 'explanation' => 'The code specifies car lengths, not metres, for this rule.'],
                ],
            ],
            [
                'category' => 'overtaking',
                'difficulty' => 'easy',
                'question' => 'If you are driving and someone wants to overtake you, what should you do?',
                'answers' => [
                    ['text' => 'Speed up so they cannot overtake',     'correct' => false, 'explanation' => 'Preventing someone from overtaking is dangerous and illegal.'],
                    ['text' => 'Brake suddenly to let them pass',      'correct' => false, 'explanation' => 'Braking suddenly could cause a rear collision.'],
                    ['text' => 'Maintain your normal speed',           'correct' => true,  'explanation' => 'You should maintain your speed and allow the overtaking driver to pass safely.'],
                    ['text' => 'Move to the right to block them',      'correct' => false, 'explanation' => 'Deliberately blocking an overtaking vehicle is dangerous and illegal.'],
                ],
            ],

            // -------------------------------------------------------
            // PARKING
            // -------------------------------------------------------
            [
                'category' => 'parking',
                'difficulty' => 'medium',
                'question' => 'How close to a T-junction are you allowed to park?',
                'answers' => [
                    ['text' => '5 metres',  'correct' => false, 'explanation' => '5 metres is too close to a junction.'],
                    ['text' => '10 metres', 'correct' => false, 'explanation' => '10 metres is still too close.'],
                    ['text' => '15 metres', 'correct' => true,  'explanation' => 'You must not park within 15 metres of a T-junction.'],
                    ['text' => '20 metres', 'correct' => false, 'explanation' => 'While 20 metres is safer, the minimum stated rule is 15 metres.'],
                ],
            ],
            [
                'category' => 'parking',
                'difficulty' => 'medium',
                'question' => 'If you must stop suddenly, what is the best place to stop?',
                'answers' => [
                    ['text' => 'On a pedestrian crossing',              'correct' => false, 'explanation' => 'Stopping on a crossing blocks pedestrians and is prohibited.'],
                    ['text' => 'On the sidewalk',                       'correct' => false, 'explanation' => 'Parking on the sidewalk blocks pedestrians and is illegal.'],
                    ['text' => 'On the right-hand side of a one-way street', 'correct' => true, 'explanation' => 'On a one-way street, parking on the right is permitted as traffic only flows one way.'],
                    ['text' => 'Opposite a junction',                   'correct' => false, 'explanation' => 'Parking opposite a junction obstructs visibility.'],
                ],
            ],
            [
                'category' => 'parking',
                'difficulty' => 'easy',
                'question' => 'When are you allowed to use hazard lights on the main road?',
                'answers' => [
                    ['text' => 'When driving slowly in traffic',                   'correct' => false, 'explanation' => 'Hazard lights should not be used when moving in traffic.'],
                    ['text' => 'When parked temporarily and obstructing traffic',  'correct' => true,  'explanation' => 'Hazard lights may be used when you are temporarily parked and obstructing the flow of traffic.'],
                    ['text' => 'When it is raining heavily',                       'correct' => false, 'explanation' => 'Rain is not a reason to use hazard lights while moving.'],
                    ['text' => 'When driving at night',                            'correct' => false, 'explanation' => 'Headlights are used at night, not hazard lights.'],
                ],
            ],

            // -------------------------------------------------------
            // SEATBELTS & CHILD RESTRAINTS
            // -------------------------------------------------------
            [
                'category' => 'seatbelts-child-restraints',
                'difficulty' => 'easy',
                'question' => 'Is wearing a seatbelt mandatory in Barbados?',
                'answers' => [
                    ['text' => 'Only for the driver',               'correct' => false, 'explanation' => 'All occupants are required to wear seatbelts.'],
                    ['text' => 'Only on highways',                  'correct' => false, 'explanation' => 'Seatbelts are compulsory on all roads.'],
                    ['text' => 'Yes, for all occupants',            'correct' => true,  'explanation' => 'It is compulsory for both drivers and all passengers to wear seatbelts in Barbados.'],
                    ['text' => 'No, it is advisory only',           'correct' => false, 'explanation' => 'Wearing a seatbelt is a legal requirement, not advisory.'],
                ],
            ],
            [
                'category' => 'seatbelts-child-restraints',
                'difficulty' => 'easy',
                'question' => 'What driving manoeuvre are you permitted to perform without a seatbelt?',
                'answers' => [
                    ['text' => 'Driving in a car park',  'correct' => false, 'explanation' => 'Seatbelts should be worn in car parks too.'],
                    ['text' => 'Driving at low speed',   'correct' => false, 'explanation' => 'Speed does not exempt you from wearing a seatbelt.'],
                    ['text' => 'Reversing',              'correct' => true,  'explanation' => 'Reversing is the one manoeuvre that does not require a seatbelt to be worn.'],
                    ['text' => 'Parallel parking',       'correct' => false, 'explanation' => 'Parallel parking is not an exemption from wearing a seatbelt.'],
                ],
            ],
            [
                'category' => 'seatbelts-child-restraints',
                'difficulty' => 'medium',
                'question' => 'If no child seat is available, which child may use an adult seatbelt?',
                'answers' => [
                    ['text' => 'A child under 3 years of age',                          'correct' => false, 'explanation' => 'Very young children must use an appropriate child seat, not an adult belt.'],
                    ['text' => 'A child 3 to 11 years old and under 5 ft in height',    'correct' => false, 'explanation' => 'This group should use a child restraint as a first choice.'],
                    ['text' => 'A child under 13 but approximately 5 ft (1.5m) in height', 'correct' => true, 'explanation' => 'If no child restraint is available, a child under 13 but around 5 ft tall may use an adult seatbelt.'],
                    ['text' => 'Any child over 5 years old',                            'correct' => false, 'explanation' => 'Age alone is not the determining factor — height also matters.'],
                ],
            ],
            [
                'category' => 'seatbelts-child-restraints',
                'difficulty' => 'medium',
                'question' => 'Children are wearing seatbelts and cannot move freely. Do you still need to use child safety locks on the doors?',
                'answers' => [
                    ['text' => 'No — the seatbelt is sufficient',    'correct' => false, 'explanation' => 'Safety locks provide an additional layer of protection.'],
                    ['text' => 'Yes — safety locks should still be used', 'correct' => true, 'explanation' => 'Even with seatbelts, child safety locks on doors provide extra protection and should be engaged.'],
                    ['text' => 'Only on highways',                   'correct' => false, 'explanation' => 'Safety locks should be used on all roads.'],
                    ['text' => 'Only if children are under 5',       'correct' => false, 'explanation' => 'Safety locks are recommended for all young children.'],
                ],
            ],

            // -------------------------------------------------------
            // PEDESTRIANS & CYCLISTS
            // -------------------------------------------------------
            [
                'category' => 'pedestrians-cyclists',
                'difficulty' => 'easy',
                'question' => 'If there is no footpath, which side of the road should pedestrians walk on?',
                'answers' => [
                    ['text' => 'The left side, with traffic behind them',   'correct' => false, 'explanation' => 'Walking with traffic behind you reduces your awareness of approaching vehicles.'],
                    ['text' => 'Either side depending on traffic volume',   'correct' => false, 'explanation' => 'The rule is consistent regardless of traffic volume.'],
                    ['text' => 'The right side, facing oncoming traffic',   'correct' => true,  'explanation' => 'Pedestrians should walk on the right side of the road facing oncoming traffic so they can see and react to approaching vehicles.'],
                    ['text' => 'The middle of the road',                    'correct' => false, 'explanation' => 'Walking in the middle of the road is extremely dangerous.'],
                ],
            ],
            [
                'category' => 'pedestrians-cyclists',
                'difficulty' => 'medium',
                'question' => 'A pedestrian wants to cross the road and an approaching car stops and waves them across. What should the pedestrian do?',
                'answers' => [
                    ['text' => 'Cross immediately since the car has stopped',    'correct' => false, 'explanation' => 'One stopped car does not mean all lanes are safe.'],
                    ['text' => 'Stop in the middle of the road and wait',        'correct' => false, 'explanation' => 'Stopping in the middle of the road is dangerous.'],
                    ['text' => 'Stop close to the sidewalk and check all traffic', 'correct' => true, 'explanation' => 'The pedestrian should check that ALL traffic has stopped before crossing, not just the one waving car.'],
                    ['text' => 'Run quickly across the road',                    'correct' => false, 'explanation' => 'Running increases the risk of falling and reduces reaction time for drivers.'],
                ],
            ],
            [
                'category' => 'pedestrians-cyclists',
                'difficulty' => 'easy',
                'question' => 'If a ball rolls across the road while you are driving, what should you do?',
                'answers' => [
                    ['text' => 'Speed up and pass before the child crosses',  'correct' => false, 'explanation' => 'Speeding up near children is extremely dangerous.'],
                    ['text' => 'Continue to drive slowly',                    'correct' => false, 'explanation' => 'Simply slowing down is not sufficient — a child may run out at any moment.'],
                    ['text' => 'Stop and let the child retrieve the ball',    'correct' => true,  'explanation' => 'A ball on the road means a child is likely to follow. Stop and let the child safely retrieve it.'],
                    ['text' => 'Sound your horn and continue',                'correct' => false, 'explanation' => 'Sounding your horn does not make the situation safe.'],
                ],
            ],
            [
                'category' => 'pedestrians-cyclists',
                'difficulty' => 'medium',
                'question' => 'You give way to a bus that is signalling to pull away from a stop. What else must you watch for?',
                'answers' => [
                    ['text' => 'The bus driver',             'correct' => false, 'explanation' => 'The bus driver is already accounted for in the situation.'],
                    ['text' => 'Pedestrians',                'correct' => true,  'explanation' => 'As a bus pulls away, passengers may cross the road in front of or behind it — always watch for pedestrians.'],
                    ['text' => 'Other buses',                'correct' => false, 'explanation' => 'Other buses are a secondary concern; pedestrians are the immediate hazard.'],
                    ['text' => 'Traffic lights ahead',       'correct' => false, 'explanation' => 'Traffic lights are a constant concern but pedestrians are the specific risk here.'],
                ],
            ],

            // -------------------------------------------------------
            // LEARNER DRIVERS
            // -------------------------------------------------------
            [
                'category' => 'learner-drivers',
                'difficulty' => 'easy',
                'question' => 'Should the "L" sign (learner plate) be displayed on the vehicle at all times?',
                'answers' => [
                    ['text' => 'Yes, at all times',                    'correct' => false, 'explanation' => 'The L plate only needs to be displayed when the learner is driving.'],
                    ['text' => 'Only when the learner is driving',     'correct' => true,  'explanation' => 'The L sign must be displayed only when the learner driver is behind the wheel.'],
                    ['text' => 'Only when driving on highways',        'correct' => false, 'explanation' => 'The L plate requirement applies whenever the learner is driving, not just on highways.'],
                    ['text' => 'Only when the instructor is present',  'correct' => false, 'explanation' => 'The L plate relates to the learner driving, not to the instructor\'s presence.'],
                ],
            ],
            [
                'category' => 'learner-drivers',
                'difficulty' => 'easy',
                'question' => 'What is the minimum age to apply for a learner\'s permit / regulation examination in Barbados?',
                'answers' => [
                    ['text' => '14 years', 'correct' => false, 'explanation' => '14 is too young to apply for a learner\'s permit in Barbados.'],
                    ['text' => '18 years', 'correct' => false, 'explanation' => '18 is the age for some vehicle categories but not the minimum age for a learner\'s permit.'],
                    ['text' => '16 years', 'correct' => true,  'explanation' => 'Applicants must be 16 years or older to sit the Regulation Examination and apply for a Learner\'s Permit.'],
                    ['text' => '17 years', 'correct' => false, 'explanation' => 'The minimum age is 16, not 17.'],
                ],
            ],
            [
                'category' => 'learner-drivers',
                'difficulty' => 'medium',
                'question' => 'What is the minimum age to learn to drive a truck (heavy goods vehicle) in Barbados?',
                'answers' => [
                    ['text' => '16 years', 'correct' => false, 'explanation' => '16 is the minimum for a standard learner\'s permit, not for trucks.'],
                    ['text' => '21 years', 'correct' => false, 'explanation' => '21 is not the minimum age for learning to drive a truck.'],
                    ['text' => '17 years', 'correct' => false, 'explanation' => '17 is not the correct minimum age for trucks.'],
                    ['text' => '18 years', 'correct' => true,  'explanation' => 'The minimum age to learn to drive a truck (heavy goods vehicle) is 18 years.'],
                ],
            ],
            [
                'category' => 'learner-drivers',
                'difficulty' => 'medium',
                'question' => 'How long must you hold a valid learner\'s permit before you can take the practical driving test?',
                'answers' => [
                    ['text' => '1 month',  'correct' => false, 'explanation' => 'One month is not sufficient time before taking the driving test.'],
                    ['text' => '6 months', 'correct' => false, 'explanation' => 'Six months is not the minimum required period.'],
                    ['text' => '3 months', 'correct' => true,  'explanation' => 'You must hold a valid learner\'s permit for at least 3 months before sitting the practical driving test.'],
                    ['text' => '2 months', 'correct' => false, 'explanation' => 'Two months is not the required minimum period.'],
                ],
            ],
            [
                'category' => 'learner-drivers',
                'difficulty' => 'easy',
                'question' => 'Who issues the learner\'s permit in Barbados?',
                'answers' => [
                    ['text' => 'The Police',                        'correct' => false, 'explanation' => 'The police do not issue learner\'s permits.'],
                    ['text' => 'The Court',                         'correct' => false, 'explanation' => 'The court does not issue learner\'s permits.'],
                    ['text' => 'The Licensing Authority (BLA)',     'correct' => true,  'explanation' => 'The Barbados Licensing Authority (BLA) is responsible for issuing learner\'s permits.'],
                    ['text' => 'The Ministry of Transport',         'correct' => false, 'explanation' => 'The ministry does not directly issue permits — the BLA does.'],
                ],
            ],

            // -------------------------------------------------------
            // VEHICLE LIGHTING
            // -------------------------------------------------------
            [
                'category' => 'vehicle-lighting',
                'difficulty' => 'easy',
                'question' => 'When must you use your vehicle\'s lights in Barbados?',
                'answers' => [
                    ['text' => 'Only at night',                              'correct' => false, 'explanation' => 'Lights are also required in poor visibility conditions during the day.'],
                    ['text' => 'At night or in conditions of poor visibility', 'correct' => true,  'explanation' => 'You must use headlights at night or whenever visibility is poor.'],
                    ['text' => 'Only in heavy rain',                         'correct' => false, 'explanation' => 'Any poor visibility condition requires lights, not just heavy rain.'],
                    ['text' => 'Only on unlit roads',                        'correct' => false, 'explanation' => 'Lights are required at night and in poor visibility on all roads.'],
                ],
            ],
            [
                'category' => 'vehicle-lighting',
                'difficulty' => 'medium',
                'question' => 'When are you permitted to drive with fog lights in Barbados?',
                'answers' => [
                    ['text' => 'When it starts to get dark',                          'correct' => false, 'explanation' => 'Darkness alone does not require fog lights — headlights are used at night.'],
                    ['text' => 'With permission from the Licensing Authority',        'correct' => false, 'explanation' => 'No special permission is needed — fog lights are used in specific conditions.'],
                    ['text' => 'In heavy fog only',                                   'correct' => true,  'explanation' => 'Fog lights should only be used in heavy fog when visibility is significantly reduced.'],
                    ['text' => 'At all times on highways',                            'correct' => false, 'explanation' => 'Fog lights are not required on highways unless there is heavy fog.'],
                ],
            ],
            [
                'category' => 'vehicle-lighting',
                'difficulty' => 'medium',
                'question' => 'Heavy vehicles parked along the road at night should:',
                'answers' => [
                    ['text' => 'Switch off all lights to save battery',     'correct' => false, 'explanation' => 'Switching off all lights makes the vehicle invisible to other drivers.'],
                    ['text' => 'Use full headlights',                       'correct' => false, 'explanation' => 'Full headlights would dazzle other road users.'],
                    ['text' => 'Use illuminated park lights',               'correct' => true,  'explanation' => 'Heavy vehicles parked on the road at night must display illuminated park lights so other drivers can see them.'],
                    ['text' => 'Place cones around the vehicle only',       'correct' => false, 'explanation' => 'Cones alone without lights are insufficient at night.'],
                ],
            ],

            // -------------------------------------------------------
            // SAFE DRIVING PRACTICES
            // -------------------------------------------------------
            [
                'category' => 'safe-driving-practices',
                'difficulty' => 'easy',
                'question' => 'What is the great potential danger of using a cellular phone while driving?',
                'answers' => [
                    ['text' => 'It drains your phone battery',       'correct' => false, 'explanation' => 'Battery drain is not a road safety concern.'],
                    ['text' => 'You may cause an accident',          'correct' => true,  'explanation' => 'Using a mobile phone while driving distracts the driver and greatly increases the risk of causing an accident.'],
                    ['text' => 'It is expensive',                    'correct' => false, 'explanation' => 'Cost is not a road safety concern.'],
                    ['text' => 'It upsets other road users',         'correct' => false, 'explanation' => 'While this may be true, the primary danger is causing an accident.'],
                ],
            ],
            [
                'category' => 'safe-driving-practices',
                'difficulty' => 'easy',
                'question' => 'What should you do if you are unsure whether your cough medicine will affect your driving?',
                'answers' => [
                    ['text' => 'Drive slowly to compensate',         'correct' => false, 'explanation' => 'Impaired driving at any speed is dangerous.'],
                    ['text' => 'Read the label',                     'correct' => true,  'explanation' => 'Always read the label of any medication to check whether it may impair your ability to drive.'],
                    ['text' => 'Ask a friend',                       'correct' => false, 'explanation' => 'A friend\'s opinion is not a reliable source for medical information.'],
                    ['text' => 'Take it anyway and see how you feel', 'correct' => false, 'explanation' => 'You should not risk driving if medication may impair you.'],
                ],
            ],
            [
                'category' => 'safe-driving-practices',
                'difficulty' => 'medium',
                'question' => 'In good conditions, a two-second gap between your car and the car in front is sufficient. What gap should you leave if the roads are wet?',
                'answers' => [
                    ['text' => '2 seconds',  'correct' => false, 'explanation' => 'The two-second rule applies in dry conditions only.'],
                    ['text' => '3 seconds',  'correct' => false, 'explanation' => '3 seconds is better but still not the recommended wet-road gap.'],
                    ['text' => '4 seconds',  'correct' => true,  'explanation' => 'In wet conditions, you should double the dry gap and allow at least 4 seconds between you and the vehicle ahead.'],
                    ['text' => '6 seconds',  'correct' => false, 'explanation' => 'While more is always safer, the standard recommendation is to double the two-second rule to four seconds.'],
                ],
            ],
            [
                'category' => 'safe-driving-practices',
                'difficulty' => 'easy',
                'question' => 'In Barbados, on which side of the road do vehicles drive?',
                'answers' => [
                    ['text' => 'The right side', 'correct' => false, 'explanation' => 'Barbados follows the British system of driving on the left.'],
                    ['text' => 'Either side',     'correct' => false, 'explanation' => 'There is a fixed rule for which side of the road to drive on.'],
                    ['text' => 'The left side',   'correct' => true,  'explanation' => 'Like many Caribbean nations with British influence, Barbados drives on the left side of the road.'],
                    ['text' => 'The centre',      'correct' => false, 'explanation' => 'Driving in the centre of the road is dangerous and illegal.'],
                ],
            ],
            [
                'category' => 'safe-driving-practices',
                'difficulty' => 'medium',
                'question' => 'When driving through a residential area and you see an ice cream van parked by the side of the road, what should you look for?',
                'answers' => [
                    ['text' => 'The ice cream vendor',             'correct' => false, 'explanation' => 'The vendor is not the hazard — children approaching the van are.'],
                    ['text' => 'Children running into the road',   'correct' => true,  'explanation' => 'Children are attracted to ice cream vans and may run into the road without looking. Slow down and be alert.'],
                    ['text' => 'Delivery vehicles',                'correct' => false, 'explanation' => 'Delivery vehicles are not the specific hazard near an ice cream van.'],
                    ['text' => 'Traffic signals ahead',            'correct' => false, 'explanation' => 'Traffic signals are always relevant but not the specific hazard here.'],
                ],
            ],

            // -------------------------------------------------------
            // ANIMALS ON THE ROAD
            // -------------------------------------------------------
            [
                'category' => 'animals-on-the-road',
                'difficulty' => 'easy',
                'question' => 'There are animals moving slowly on the road. What should you do?',
                'answers' => [
                    ['text' => 'Sound your horn loudly to move them', 'correct' => false, 'explanation' => 'Loud horns can startle animals and cause them to behave unpredictably.'],
                    ['text' => 'Drive quickly past them',             'correct' => false, 'explanation' => 'Driving quickly past animals is dangerous for both you and the animals.'],
                    ['text' => 'Wait or drive very slowly',           'correct' => true,  'explanation' => 'You should wait patiently or drive very slowly and give animals plenty of space.'],
                    ['text' => 'Flash your headlights at them',       'correct' => false, 'explanation' => 'Flashing lights can startle animals further.'],
                ],
            ],
            [
                'category' => 'animals-on-the-road',
                'difficulty' => 'hard',
                'question' => 'Between what times are large animals allowed to be led on a busy road in Barbados?',
                'answers' => [
                    ['text' => 'Between 7:00 am–9:00 am and 3:30 pm–5:30 pm', 'correct' => true,  'explanation' => 'Large animals may be led on busy roads between 7:00–9:00 am and 3:30–5:30 pm.'],
                    ['text' => 'Between 6:00 am–8:00 am and 2:00 pm–4:00 pm', 'correct' => false, 'explanation' => 'These are not the correct permitted times.'],
                    ['text' => 'Between 6:00 am–10:00 am and 1:00 pm–3:00 pm', 'correct' => false, 'explanation' => 'These are not the correct permitted times.'],
                    ['text' => 'At any time as long as a handler is present',  'correct' => false, 'explanation' => 'There are specific time restrictions for leading large animals on busy roads.'],
                ],
            ],

            // -------------------------------------------------------
            // ROAD SIGNS (PDF additions)
            // -------------------------------------------------------
            [
                'category' => 'road-signs',
                'difficulty' => 'easy',
                'question' => 'What do blue circular road signs do?',
                'answers' => [
                    ['text' => 'Warn of hazards ahead',               'correct' => false, 'explanation' => 'Triangular signs warn of hazards.'],
                    ['text' => 'Give positive orders and commands',    'correct' => true,  'explanation' => 'Blue circular signs give positive orders — they tell you what you MUST do.'],
                    ['text' => 'Give negative orders and prohibitions', 'correct' => false, 'explanation' => 'Red or white circles with red borders give prohibitions.'],
                    ['text' => 'Give information about places',        'correct' => false, 'explanation' => 'Informational signs are usually rectangular.'],
                ],
            ],
            [
                'category' => 'road-signs',
                'difficulty' => 'easy',
                'question' => 'What do red circles or white circles with red borders indicate?',
                'answers' => [
                    ['text' => 'Negative orders and prohibitions', 'correct' => true,  'explanation' => 'Red or white circular signs with red borders give prohibitions — they tell you what you must NOT do.'],
                    ['text' => 'Positive orders and commands',     'correct' => false, 'explanation' => 'Positive orders are given by blue circular signs.'],
                    ['text' => 'Hazard warnings',                  'correct' => false, 'explanation' => 'Hazard warnings are given by triangular signs.'],
                    ['text' => 'Directions and information',       'correct' => false, 'explanation' => 'Directional information is given by rectangular signs.'],
                ],
            ],
            [
                'category' => 'road-signs',
                'difficulty' => 'easy',
                'question' => 'A triangle with its apex pointing upward and a red border — what does it do?',
                'answers' => [
                    ['text' => 'Warns of hazards ahead',     'correct' => true,  'explanation' => 'A triangular sign with the apex pointing upward warns drivers of a hazard ahead.'],
                    ['text' => 'Is a give way sign',          'correct' => false, 'explanation' => 'A give way sign is a triangle with the apex pointing downward.'],
                    ['text' => 'Is a stop sign',              'correct' => false, 'explanation' => 'The stop sign is octagonal.'],
                    ['text' => 'Gives a positive command',   'correct' => false, 'explanation' => 'Commands are given by circular signs.'],
                ],
            ],
            [
                'category' => 'road-signs',
                'difficulty' => 'easy',
                'question' => 'What is the give way sign?',
                'answers' => [
                    ['text' => 'A triangle with the apex pointing downward',  'correct' => true,  'explanation' => 'The give way sign is an inverted triangle — apex pointing down.'],
                    ['text' => 'A triangle with the apex pointing upward',    'correct' => false, 'explanation' => 'An upward apex triangle is a hazard warning sign.'],
                    ['text' => 'A rectangle with an arrow',                   'correct' => false, 'explanation' => 'Rectangles are used for directional or informational signs.'],
                    ['text' => 'A circular sign with a red border',           'correct' => false, 'explanation' => 'Circular signs with red borders give prohibitions.'],
                ],
            ],
            [
                'category' => 'road-signs',
                'difficulty' => 'easy',
                'question' => 'A broken yellow line painted along the road is:',
                'answers' => [
                    ['text' => 'A hazard warning line',  'correct' => true,  'explanation' => 'A broken yellow line is a hazard warning line alerting drivers to a potential danger ahead.'],
                    ['text' => 'A stop line',             'correct' => false, 'explanation' => 'Stop lines are solid white lines across the road.'],
                    ['text' => 'A give way line',         'correct' => false, 'explanation' => 'Give way lines are broken white lines across the road.'],
                    ['text' => 'A centre line',           'correct' => false, 'explanation' => 'Centre lines are white lines dividing lanes.'],
                ],
            ],
            [
                'category' => 'road-signs',
                'difficulty' => 'easy',
                'question' => 'Areas of yellow stripes painted diagonally on the road are called:',
                'answers' => [
                    ['text' => 'Traffic lines',  'correct' => false, 'explanation' => 'Traffic lines is not the correct term for these markings.'],
                    ['text' => 'Chevrons',        'correct' => true,  'explanation' => 'Yellow diagonal hatching on the road surface are called chevrons. Vehicles must not enter these areas.'],
                    ['text' => 'Caution lines',   'correct' => false, 'explanation' => 'Caution lines is not the official term.'],
                    ['text' => 'Rumble strips',   'correct' => false, 'explanation' => 'Rumble strips are raised or textured surfaces, not painted yellow stripes.'],
                ],
            ],
            [
                'category' => 'road-signs',
                'difficulty' => 'easy',
                'question' => 'Should vehicles drive into areas marked with yellow or white diagonal chevron stripes on the road?',
                'answers' => [
                    ['text' => 'Never',                        'correct' => true,  'explanation' => 'Chevron-marked areas must never be driven on — they separate opposing traffic flows or protect vulnerable areas.'],
                    ['text' => 'Yes, if the road is clear',    'correct' => false, 'explanation' => 'Chevron areas must not be entered regardless of traffic conditions.'],
                    ['text' => 'Only in emergencies',          'correct' => false, 'explanation' => 'Chevron areas are not emergency stopping lanes.'],
                    ['text' => 'Only for short distances',     'correct' => false, 'explanation' => 'There is no permitted distance — chevron areas must not be entered.'],
                ],
            ],
            [
                'category' => 'road-signs',
                'difficulty' => 'medium',
                'question' => 'A white triangular sign with a red border and three arrows arranged in a clockwise circle means:',
                'answers' => [
                    ['text' => 'Mini-roundabout',    'correct' => false, 'explanation' => 'A mini-roundabout is shown by a circular sign with three arrows, not triangular.'],
                    ['text' => 'Ring road',           'correct' => false, 'explanation' => 'Ring road signs are rectangular and directional.'],
                    ['text' => 'Roundabout ahead',    'correct' => true,  'explanation' => 'A triangular sign with three clockwise arrows warns of a roundabout junction ahead.'],
                    ['text' => 'One-way traffic',     'correct' => false, 'explanation' => 'One-way traffic signs use a single directional arrow.'],
                ],
            ],
            [
                'category' => 'road-signs',
                'difficulty' => 'medium',
                'question' => 'A white triangular sign with a red border and a black cross in the middle means:',
                'answers' => [
                    ['text' => 'Staggered road junction', 'correct' => false, 'explanation' => 'A staggered junction sign shows an offset cross.'],
                    ['text' => 'Crossroads ahead',        'correct' => true,  'explanation' => 'A triangular sign with a cross indicates a crossroads junction ahead.'],
                    ['text' => 'Minor road junction',     'correct' => false, 'explanation' => 'A minor road junction sign shows a T-shape.'],
                    ['text' => 'No entry from all sides', 'correct' => false, 'explanation' => 'No entry is shown by a red circle with a white horizontal bar.'],
                ],
            ],
            [
                'category' => 'road-signs',
                'difficulty' => 'easy',
                'question' => 'A sign showing a red car and a black car side by side means:',
                'answers' => [
                    ['text' => 'No overtaking',                    'correct' => true,  'explanation' => 'Two cars side by side (one red, one black) is the no-overtaking sign — you must not pass other moving vehicles.'],
                    ['text' => 'Overtake only when clear',         'correct' => false, 'explanation' => 'There is no sign specifically permitting overtaking when clear.'],
                    ['text' => 'Dual carriageway ahead',           'correct' => false, 'explanation' => 'Dual carriageway signs show road markings, not cars.'],
                    ['text' => 'Cars only allowed in this lane',   'correct' => false, 'explanation' => 'Lane-use restrictions use different symbols.'],
                ],
            ],
            [
                'category' => 'road-signs',
                'difficulty' => 'easy',
                'question' => 'Where will you find directional signs with white coloured backgrounds?',
                'answers' => [
                    ['text' => 'On the highway',     'correct' => false, 'explanation' => 'Highway directional signs have green backgrounds.'],
                    ['text' => 'On minor roads',     'correct' => true,  'explanation' => 'Directional signs on minor roads have white backgrounds.'],
                    ['text' => 'At crossroads only', 'correct' => false, 'explanation' => 'The background colour is not specific to crossroads.'],
                    ['text' => 'At roundabouts',     'correct' => false, 'explanation' => 'Roundabout direction signs follow the same colour scheme as the road type.'],
                ],
            ],
            [
                'category' => 'road-signs',
                'difficulty' => 'easy',
                'question' => 'If a parked car blocks your view when you wish to cross the road, where should you stand?',
                'answers' => [
                    ['text' => 'On the inside edge, close to the vehicle',    'correct' => false, 'explanation' => 'Standing close to the car keeps you hidden from traffic.'],
                    ['text' => 'On the outside edge of the parked vehicle',   'correct' => true,  'explanation' => 'Stand near the outside edge of the vehicle so you can see oncoming traffic without stepping fully into the road.'],
                    ['text' => 'Somewhere in the middle of the vehicle',      'correct' => false, 'explanation' => 'The middle gives no advantage in visibility.'],
                    ['text' => 'Step into the road to look both ways',        'correct' => false, 'explanation' => 'Stepping directly into the road is dangerous before you confirm it is clear.'],
                ],
            ],

            // -------------------------------------------------------
            // TRAFFIC LIGHTS & SIGNALS (PDF additions)
            // -------------------------------------------------------
            [
                'category' => 'traffic-lights-signals',
                'difficulty' => 'easy',
                'question' => 'What does a solid red traffic light mean?',
                'answers' => [
                    ['text' => 'Stop',                                   'correct' => true,  'explanation' => 'A solid red light means stop and wait behind the stop line.'],
                    ['text' => 'Stop only if the road is clear',         'correct' => false, 'explanation' => 'You must stop at a red light regardless of whether the road is clear.'],
                    ['text' => 'Give way to traffic on your right',      'correct' => false, 'explanation' => 'Give way rules are separate from traffic light signals.'],
                    ['text' => 'Proceed with caution',                   'correct' => false, 'explanation' => 'Red means stop — not proceed.'],
                ],
            ],
            [
                'category' => 'traffic-lights-signals',
                'difficulty' => 'easy',
                'question' => 'What does a flashing red traffic light mean?',
                'answers' => [
                    ['text' => 'Stop and proceed when it is safe to do so', 'correct' => true,  'explanation' => 'A flashing red light means stop completely, then proceed only when it is safe — similar to a stop sign.'],
                    ['text' => 'Drive through with caution',               'correct' => false, 'explanation' => 'A flashing red still requires a complete stop.'],
                    ['text' => 'Use it as a give way',                     'correct' => false, 'explanation' => 'A flashing red requires a full stop, not just a give way.'],
                    ['text' => 'Stop indefinitely until it turns green',   'correct' => false, 'explanation' => 'Once it is safe to proceed, you may go.'],
                ],
            ],
            [
                'category' => 'traffic-lights-signals',
                'difficulty' => 'easy',
                'question' => 'After a green traffic light, what colour light would you NOT normally expect to see?',
                'answers' => [
                    ['text' => 'Red',    'correct' => false, 'explanation' => 'Red follows amber, which follows green.'],
                    ['text' => 'Amber',  'correct' => false, 'explanation' => 'Amber comes directly after green.'],
                    ['text' => 'White',  'correct' => true,  'explanation' => 'White is not part of the traffic light sequence. After green comes amber, then red.'],
                    ['text' => 'None',   'correct' => false, 'explanation' => 'Traffic lights always continue cycling.'],
                ],
            ],
            [
                'category' => 'traffic-lights-signals',
                'difficulty' => 'easy',
                'question' => 'After a solid amber traffic light, which colour would you NOT expect to see next?',
                'answers' => [
                    ['text' => 'Red',           'correct' => false, 'explanation' => 'Red follows solid amber in the normal sequence.'],
                    ['text' => 'Green',          'correct' => true,  'explanation' => 'Green does not follow directly after amber — red comes next, then red with amber, then green.'],
                    ['text' => 'Red and amber',  'correct' => false, 'explanation' => 'Red and amber together (prepare to go) appears after a plain red.'],
                    ['text' => 'Flashing amber', 'correct' => false, 'explanation' => 'Flashing amber can appear in certain situations.'],
                ],
            ],
            [
                'category' => 'traffic-lights-signals',
                'difficulty' => 'medium',
                'question' => 'What does a green arrow attached to a traffic light indicate?',
                'answers' => [
                    ['text' => 'You must stop',                              'correct' => false, 'explanation' => 'A green arrow means you may proceed.'],
                    ['text' => 'Move in the direction the arrow points',     'correct' => true,  'explanation' => 'A green filter arrow indicates you may proceed in that direction only, even if the main light is red.'],
                    ['text' => 'Approach with caution',                     'correct' => false, 'explanation' => 'Green means go — not caution.'],
                    ['text' => 'Yield to oncoming traffic',                 'correct' => false, 'explanation' => 'A green filter arrow gives you the right to proceed without giving way.'],
                ],
            ],
            [
                'category' => 'traffic-lights-signals',
                'difficulty' => 'easy',
                'question' => 'How should a school crossing warden signal vehicles to stop?',
                'answers' => [
                    ['text' => 'By shouting at drivers',                    'correct' => false, 'explanation' => 'Shouting is not a recognised official signal.'],
                    ['text' => 'By waving both arms',                       'correct' => false, 'explanation' => 'Waving arms is not the official procedure.'],
                    ['text' => 'By displaying a stop sign',                 'correct' => true,  'explanation' => 'A school crossing warden signals vehicles to stop by holding out an official stop sign.'],
                    ['text' => 'By blowing a whistle',                     'correct' => false, 'explanation' => 'A whistle alone is not the primary stop signal for school crossing wardens.'],
                ],
            ],
            [
                'category' => 'traffic-lights-signals',
                'difficulty' => 'easy',
                'question' => 'If traffic lights have failed at a junction, how should you proceed?',
                'answers' => [
                    ['text' => 'Follow the normal light sequence from memory',  'correct' => false, 'explanation' => 'There is no light to follow when the signals have failed.'],
                    ['text' => 'Proceed with caution, treating it as an unmarked junction', 'correct' => true, 'explanation' => 'When traffic lights fail, treat the junction as an unmarked junction and proceed with caution, giving way as necessary.'],
                    ['text' => 'Stop and wait indefinitely',                    'correct' => false, 'explanation' => 'You may proceed once it is safe to do so.'],
                    ['text' => 'Traffic turning right has priority',            'correct' => false, 'explanation' => 'No single direction has automatic priority when lights fail.'],
                ],
            ],
            [
                'category' => 'traffic-lights-signals',
                'difficulty' => 'easy',
                'question' => 'When a police officer or traffic warden signals for pedestrians to cross, they should cross:',
                'answers' => [
                    ['text' => 'Behind the officer',  'correct' => false, 'explanation' => 'Pedestrians should cross in front of the officer.'],
                    ['text' => 'In front of the officer', 'correct' => true,  'explanation' => 'Once signalled, pedestrians cross in front of the officer, who is facing and controlling the traffic.'],
                    ['text' => 'Neither — wait for a gap in traffic',  'correct' => false, 'explanation' => 'Once the officer has signalled, it is safe to cross in front of them.'],
                    ['text' => 'Only after the officer has moved',     'correct' => false, 'explanation' => 'The officer remains in position while pedestrians cross.'],
                ],
            ],

            // -------------------------------------------------------
            // SPEED LIMITS (PDF additions)
            // -------------------------------------------------------
            [
                'category' => 'speed-limits',
                'difficulty' => 'medium',
                'question' => 'What is the maximum speed limit on the ABC Highway in Barbados?',
                'answers' => [
                    ['text' => '50 km/h', 'correct' => false, 'explanation' => '50 km/h is below the highway limit.'],
                    ['text' => '60 km/h', 'correct' => false, 'explanation' => '60 km/h is the default rural road limit.'],
                    ['text' => '70 km/h', 'correct' => false, 'explanation' => '70 km/h is not the posted highway limit.'],
                    ['text' => '80 km/h', 'correct' => true,  'explanation' => 'The maximum speed limit on the ABC Highway in Barbados is 80 km/h.'],
                ],
            ],
            [
                'category' => 'speed-limits',
                'difficulty' => 'hard',
                'question' => 'What is the approximate shortest stopping distance at a speed of 40 miles per hour?',
                'answers' => [
                    ['text' => '12 m (3 car lengths)',   'correct' => false, 'explanation' => 'This is only the thinking distance at 40 mph, not total stopping distance.'],
                    ['text' => '23 m (6 car lengths)',   'correct' => false, 'explanation' => 'This underestimates the total stopping distance at 40 mph.'],
                    ['text' => '36 m (9 car lengths)',   'correct' => true,  'explanation' => 'At 40 mph the thinking distance is about 12 m and braking distance about 24 m, giving a total stopping distance of approximately 36 m (120 ft) or 9 car lengths.'],
                    ['text' => '53 m (13 car lengths)',  'correct' => false, 'explanation' => 'This is closer to the stopping distance at 50 mph.'],
                ],
            ],
            [
                'category' => 'speed-limits',
                'difficulty' => 'medium',
                'question' => 'In wet road conditions, what minimum time gap should you leave between yourself and the vehicle ahead?',
                'answers' => [
                    ['text' => '2 seconds', 'correct' => false, 'explanation' => 'Two seconds is the dry-conditions minimum.'],
                    ['text' => '3 seconds', 'correct' => false, 'explanation' => 'Three seconds is not sufficient in wet conditions.'],
                    ['text' => '4 seconds', 'correct' => false, 'explanation' => 'This is often cited as a minimum but the Barbados Highway Code recommends at least 5 seconds.'],
                    ['text' => '5 seconds', 'correct' => true,  'explanation' => 'In wet conditions you should leave a gap of at least 5 seconds to allow for the increased stopping distance.'],
                ],
            ],

            // -------------------------------------------------------
            // ROUNDABOUTS & JUNCTIONS (PDF additions)
            // -------------------------------------------------------
            [
                'category' => 'roundabouts-junctions',
                'difficulty' => 'medium',
                'question' => 'Broken lines across the width of a lane at an intersection mean:',
                'answers' => [
                    ['text' => 'Give way to all vehicles at the intersection',   'correct' => true,  'explanation' => 'Broken transverse lines across a lane at an intersection indicate a give way point — yield to all crossing traffic.'],
                    ['text' => 'Give way only to traffic on the right',         'correct' => false, 'explanation' => 'Broken lines give way to all vehicles, not just those on the right.'],
                    ['text' => 'Stop completely before proceeding',             'correct' => false, 'explanation' => 'A stop line is a solid white line, not broken.'],
                    ['text' => 'Proceed without giving way',                    'correct' => false, 'explanation' => 'Broken lines at an intersection require you to give way.'],
                ],
            ],
            [
                'category' => 'roundabouts-junctions',
                'difficulty' => 'medium',
                'question' => 'How should you signal when making a left turn at a roundabout?',
                'answers' => [
                    ['text' => 'Left, then right, then left',  'correct' => false, 'explanation' => 'This sequence applies when going right around the roundabout.'],
                    ['text' => 'Signal left throughout',        'correct' => true,  'explanation' => 'When turning left at a roundabout (first exit), you signal left on approach and maintain the left signal throughout.'],
                    ['text' => 'Signal right',                  'correct' => false, 'explanation' => 'Signalling right at a roundabout indicates you intend to turn right.'],
                    ['text' => 'No signal required',            'correct' => false, 'explanation' => 'You must always signal at roundabouts to inform other road users of your intentions.'],
                ],
            ],
            [
                'category' => 'roundabouts-junctions',
                'difficulty' => 'medium',
                'question' => 'How should you signal when you want to go straight on at a roundabout?',
                'answers' => [
                    ['text' => 'Signal left throughout',          'correct' => false, 'explanation' => 'Signalling left on approach suggests you are taking the first exit.'],
                    ['text' => 'Signal right on approach',        'correct' => false, 'explanation' => 'Signalling right on approach suggests you are turning right.'],
                    ['text' => 'No signal on approach; signal left to exit', 'correct' => true,  'explanation' => 'When going straight on, no signal is needed on approach. Signal left as you pass the exit before the one you intend to take.'],
                    ['text' => 'Signal right then left',          'correct' => false, 'explanation' => 'Right then left signals are used when taking a late exit (going right around).'],
                ],
            ],
            [
                'category' => 'roundabouts-junctions',
                'difficulty' => 'medium',
                'question' => 'How should you signal when you want to turn right at a roundabout?',
                'answers' => [
                    ['text' => 'Signal left on approach',            'correct' => false, 'explanation' => 'Left on approach signals a left turn (first exit).'],
                    ['text' => 'Signal right on approach, then left to exit', 'correct' => true,  'explanation' => 'Signal right on approach to indicate a right turn, then signal left as you approach your exit.'],
                    ['text' => 'No signal needed',                   'correct' => false, 'explanation' => 'You must always signal your intentions at a roundabout.'],
                    ['text' => 'Signal left then right',             'correct' => false, 'explanation' => 'This is not the correct sequence for turning right.'],
                ],
            ],
            [
                'category' => 'roundabouts-junctions',
                'difficulty' => 'easy',
                'question' => 'At a four-way stop, who goes first?',
                'answers' => [
                    ['text' => 'The first vehicle to stop is the first to go',    'correct' => true,  'explanation' => 'At a four-way stop, the vehicle that arrived and stopped first has the right of way to proceed first.'],
                    ['text' => 'Traffic going straight has priority',             'correct' => false, 'explanation' => 'Straight-through traffic does not have automatic priority at a four-way stop.'],
                    ['text' => 'Traffic turning right goes first',                'correct' => false, 'explanation' => 'Direction of travel does not determine priority at a four-way stop.'],
                    ['text' => 'Stop until another motorist waves you through',   'correct' => false, 'explanation' => 'Order of arrival determines priority, not hand signals from other drivers.'],
                ],
            ],
            [
                'category' => 'roundabouts-junctions',
                'difficulty' => 'medium',
                'question' => 'At an unmarked crossroads, who has priority?',
                'answers' => [
                    ['text' => 'Traffic from the right',              'correct' => false, 'explanation' => 'At an unmarked crossroads, no direction has automatic right of way.'],
                    ['text' => 'The driver of the larger vehicle',    'correct' => false, 'explanation' => 'Vehicle size does not determine priority.'],
                    ['text' => 'Nobody — all traffic must give way',  'correct' => true,  'explanation' => 'At an unmarked crossroads, no vehicle has priority. All drivers must proceed with caution and be prepared to give way.'],
                    ['text' => 'Traffic going straight',              'correct' => false, 'explanation' => 'Straight-through traffic has no automatic priority at an unmarked junction.'],
                ],
            ],
            [
                'category' => 'roundabouts-junctions',
                'difficulty' => 'medium',
                'question' => 'You are coming out of a junction to turn left and another motorist is signalling to turn left into your road. What should you do?',
                'answers' => [
                    ['text' => 'Wait until the motorist has actually turned',    'correct' => true,  'explanation' => 'Never trust an indicator alone — wait until the other vehicle has actually turned before pulling out.'],
                    ['text' => 'Trust the indicator and pull out immediately',   'correct' => false, 'explanation' => 'Indicators can be left on by mistake. Always wait for the manoeuvre to begin before pulling out.'],
                    ['text' => 'Go out cautiously at the same time',            'correct' => false, 'explanation' => 'This is risky — what if the driver passes straight through without turning?'],
                    ['text' => 'Sound your horn to confirm their intention',     'correct' => false, 'explanation' => 'Sounding your horn does not verify the other driver\'s intentions.'],
                ],
            ],
            [
                'category' => 'roundabouts-junctions',
                'difficulty' => 'easy',
                'question' => 'Why should you take special care when approaching a long vehicle making a turn at a junction?',
                'answers' => [
                    ['text' => 'It may stop suddenly',            'correct' => false, 'explanation' => 'While long vehicles do brake differently, the main concern at junctions is their turning radius.'],
                    ['text' => 'It will probably make a wide turn', 'correct' => true,  'explanation' => 'Long vehicles need extra space to complete a turn and may swing wide — stay well back to give them room.'],
                    ['text' => 'It is harder to see you',          'correct' => false, 'explanation' => 'Visibility is a concern when following closely, but the turn width is the immediate hazard.'],
                    ['text' => 'It has right of way over you',     'correct' => false, 'explanation' => 'Long vehicles have no special right of way — but they do need more space.'],
                ],
            ],
            [
                'category' => 'roundabouts-junctions',
                'difficulty' => 'medium',
                'question' => 'You are approaching a mini-roundabout. The long vehicle in front is signalling left but positioned to the right. What should you do?',
                'answers' => [
                    ['text' => 'Sound your horn to warn the driver',    'correct' => false, 'explanation' => 'Sounding your horn aggressively is unhelpful and dangerous.'],
                    ['text' => 'Overtake on the left',                  'correct' => false, 'explanation' => 'Overtaking a long vehicle turning at a roundabout is extremely dangerous.'],
                    ['text' => 'Follow the same course as the lorry',   'correct' => false, 'explanation' => 'A long vehicle needs the full width to manoeuvre — staying beside it is dangerous.'],
                    ['text' => 'Keep well back',                        'correct' => true,  'explanation' => 'Long vehicles signal left but swing right to complete a left turn. Stay well back to give them the room they need.'],
                ],
            ],
            [
                'category' => 'roundabouts-junctions',
                'difficulty' => 'medium',
                'question' => 'Where may you overtake on a one-way street?',
                'answers' => [
                    ['text' => 'Only on the left-hand side',           'correct' => false, 'explanation' => 'On a one-way street, you are not restricted to the left.'],
                    ['text' => 'Overtaking is not allowed',            'correct' => false, 'explanation' => 'Overtaking is permitted on one-way streets under certain conditions.'],
                    ['text' => 'Only on the right-hand side',          'correct' => false, 'explanation' => 'Both sides are permitted on a one-way street.'],
                    ['text' => 'Either on the right or the left',      'correct' => true,  'explanation' => 'On a one-way street, you may overtake on either side when it is safe to do so, as traffic flows in one direction only.'],
                ],
            ],
            [
                'category' => 'roundabouts-junctions',
                'difficulty' => 'medium',
                'question' => 'When cycling towards a roundabout with a cyclist in the left-hand lane ahead of you, in which direction should you expect them to go?',
                'answers' => [
                    ['text' => 'Left only',      'correct' => false, 'explanation' => 'Cyclists in the left lane may exit at any point.'],
                    ['text' => 'Straight only',  'correct' => false, 'explanation' => 'A cyclist in the left lane is not restricted to going straight.'],
                    ['text' => 'Any direction',  'correct' => true,  'explanation' => 'Cyclists are permitted to use the left lane to go in any direction at a roundabout — you cannot predict their exit. Give them space.'],
                    ['text' => 'Right only',     'correct' => false, 'explanation' => 'Cyclists in the left lane do not necessarily turn right.'],
                ],
            ],

            // -------------------------------------------------------
            // OVERTAKING (PDF additions)
            // -------------------------------------------------------
            [
                'category' => 'overtaking',
                'difficulty' => 'easy',
                'question' => 'When overtaking a motorcyclist, pedal cyclist or horse rider, how much room should you allow?',
                'answers' => [
                    ['text' => 'Less room than a car',       'correct' => false, 'explanation' => 'Vulnerable road users need more room, not less.'],
                    ['text' => 'More room than for a car',   'correct' => true,  'explanation' => 'Motorcyclists, cyclists and horse riders are vulnerable and can swerve unexpectedly — always leave more room than you would for a car.'],
                    ['text' => 'The same as for a car',      'correct' => false, 'explanation' => 'A vehicle has a fixed width; vulnerable road users can wobble or swerve, requiring extra clearance.'],
                    ['text' => 'Only a few centimetres',     'correct' => false, 'explanation' => 'A few centimetres is dangerously close when overtaking any road user.'],
                ],
            ],
            [
                'category' => 'overtaking',
                'difficulty' => 'medium',
                'question' => 'In which of these situations can you safely overtake?',
                'answers' => [
                    ['text' => 'At the brow of a hill',       'correct' => false, 'explanation' => 'Overtaking at the brow of a hill is prohibited — you cannot see oncoming traffic.'],
                    ['text' => 'On a hill (not at the crest)', 'correct' => true,  'explanation' => 'You may overtake on a hill as long as you are not near the crest and have a clear view of the road ahead.'],
                    ['text' => 'At a road junction',          'correct' => false, 'explanation' => 'Overtaking at a junction is prohibited.'],
                    ['text' => 'Approaching a dip in the road', 'correct' => false, 'explanation' => 'A dip in the road limits your view ahead — do not overtake.'],
                ],
            ],
            [
                'category' => 'overtaking',
                'difficulty' => 'medium',
                'question' => 'In which situation should you avoid overtaking?',
                'answers' => [
                    ['text' => 'Just after a bend',           'correct' => false, 'explanation' => 'You can overtake after a bend if the road ahead is clearly visible.'],
                    ['text' => 'In a one-way street',         'correct' => false, 'explanation' => 'Overtaking is permitted on a one-way street when safe.'],
                    ['text' => 'On a 60 km/h road',           'correct' => false, 'explanation' => 'Speed limit alone does not prohibit overtaking.'],
                    ['text' => 'Approaching a dip in the road', 'correct' => true, 'explanation' => 'A dip in the road reduces your forward visibility — an oncoming vehicle in the dip may not be visible until you are very close.'],
                ],
            ],
            [
                'category' => 'overtaking',
                'difficulty' => 'medium',
                'question' => 'You are driving behind a cyclist and want to turn left at the junction ahead. What should you do?',
                'answers' => [
                    ['text' => 'Overtake the cyclist before the junction and then turn',    'correct' => false, 'explanation' => 'Overtaking then immediately turning cuts across the cyclist\'s path and is dangerous.'],
                    ['text' => 'Pull alongside the cyclist and stay level until after the junction', 'correct' => false, 'explanation' => 'Riding alongside a cyclist while turning risks colliding with them.'],
                    ['text' => 'Hold back until the cyclist has cleared the junction',      'correct' => true,  'explanation' => 'You should hold back, allow the cyclist to pass the junction, and then make your left turn safely.'],
                    ['text' => 'Sound your horn so the cyclist knows you are turning',     'correct' => false, 'explanation' => 'Using your horn is not a substitute for giving way to the cyclist.'],
                ],
            ],

            // -------------------------------------------------------
            // PARKING (PDF additions)
            // -------------------------------------------------------
            [
                'category' => 'parking',
                'difficulty' => 'medium',
                'question' => 'What is the minimum distance you must not stop within at a roundabout?',
                'answers' => [
                    ['text' => '20 metres', 'correct' => false, 'explanation' => '20 metres is more than the required distance.'],
                    ['text' => '35 metres', 'correct' => false, 'explanation' => '35 metres is not the stated minimum.'],
                    ['text' => '15 metres', 'correct' => true,  'explanation' => 'You must not park or stop within 15 metres of a roundabout.'],
                    ['text' => '10 metres', 'correct' => false, 'explanation' => '10 metres is too close — the rule is 15 metres.'],
                ],
            ],
            [
                'category' => 'parking',
                'difficulty' => 'easy',
                'question' => 'When parking at night on the road, you should:',
                'answers' => [
                    ['text' => 'Park as close to your destination as possible',  'correct' => false, 'explanation' => 'Convenience does not override road safety requirements.'],
                    ['text' => 'Choose a well-lit place',                        'correct' => true,  'explanation' => 'Parking in a well-lit area makes your vehicle visible to other road users at night.'],
                    ['text' => 'Park close to the left with no lights on',       'correct' => false, 'explanation' => 'Vehicles must display park lights at night on the road.'],
                    ['text' => 'Park on the right-hand side of the road',       'correct' => false, 'explanation' => 'Parking on the right at night with oncoming headlights approaching is dangerous.'],
                ],
            ],
            [
                'category' => 'parking',
                'difficulty' => 'easy',
                'question' => 'How many vehicles may a vehicle tow at one time?',
                'answers' => [
                    ['text' => 'Two, if they can be secured',              'correct' => false, 'explanation' => 'Towing two vehicles simultaneously is not permitted.'],
                    ['text' => 'One at a time',                            'correct' => true,  'explanation' => 'A vehicle may only tow one other vehicle at a time.'],
                    ['text' => 'Three, if they are all small cars',        'correct' => false, 'explanation' => 'You may not tow three vehicles regardless of their size.'],
                    ['text' => 'As many as can be linked together safely', 'correct' => false, 'explanation' => 'There is a strict limit of one towed vehicle at a time.'],
                ],
            ],

            // -------------------------------------------------------
            // SEATBELTS & CHILD RESTRAINTS (PDF additions)
            // -------------------------------------------------------
            [
                'category' => 'seatbelts-child-restraints',
                'difficulty' => 'easy',
                'question' => 'Is it safe to allow children to sit behind the rear seats of a hatchback car?',
                'answers' => [
                    ['text' => 'Yes, if you can see them clearly in the rear-view mirror', 'correct' => false, 'explanation' => 'Mirror visibility does not make the seating position safe.'],
                    ['text' => 'Yes, if they are under 11 years old',                      'correct' => false, 'explanation' => 'Age does not justify placing a child in an unsafe seating position.'],
                    ['text' => 'No, only if all other seats are full',                     'correct' => false, 'explanation' => 'There are no seats behind the rear seats of a hatchback — this area is the boot.'],
                    ['text' => 'No, not in any circumstances',                             'correct' => true,  'explanation' => 'Children must never sit in the boot/load area behind the rear seats of a hatchback — it offers no crash protection.'],
                ],
            ],

            // -------------------------------------------------------
            // PEDESTRIANS & CYCLISTS (PDF additions)
            // -------------------------------------------------------
            [
                'category' => 'pedestrians-cyclists',
                'difficulty' => 'easy',
                'question' => 'After getting off a bus, when is it safe to cross the road?',
                'answers' => [
                    ['text' => 'Cross immediately in front of the bus',       'correct' => false, 'explanation' => 'Crossing in front of a stationary bus means drivers in the oncoming lane cannot see you.'],
                    ['text' => 'Cross immediately behind the bus',            'correct' => false, 'explanation' => 'The bus may be about to move, and oncoming traffic cannot see you stepping out.'],
                    ['text' => 'Wait until the bus moves off, then cross',   'correct' => true,  'explanation' => 'Wait for the bus to move away so you have a clear view of all traffic before crossing.'],
                    ['text' => 'Ask the driver to signal when it is safe',   'correct' => false, 'explanation' => 'The driver\'s responsibility ends once you have alighted.'],
                ],
            ],
            [
                'category' => 'pedestrians-cyclists',
                'difficulty' => 'easy',
                'question' => 'Why is a cyclist most vulnerable on the road?',
                'answers' => [
                    ['text' => 'They are easy for drivers to see',         'correct' => false, 'explanation' => 'Cyclists being easy to see would make them less vulnerable, not more.'],
                    ['text' => 'They are difficult for other road users to see', 'correct' => true, 'explanation' => 'Cyclists have a small profile and can easily be missed — especially in blind spots, at junctions, or in poor light.'],
                    ['text' => 'They cannot produce hand signals',         'correct' => false, 'explanation' => 'Cyclists are required to and do give hand signals.'],
                    ['text' => 'They travel faster than cars',             'correct' => false, 'explanation' => 'Cyclists generally travel slower than motor vehicles, which is a separate vulnerability.'],
                ],
            ],
            [
                'category' => 'pedestrians-cyclists',
                'difficulty' => 'easy',
                'question' => 'At road junctions, which road user is considered the least vulnerable?',
                'answers' => [
                    ['text' => 'Cyclists',        'correct' => false, 'explanation' => 'Cyclists are highly vulnerable at junctions.'],
                    ['text' => 'Motorcyclists',   'correct' => false, 'explanation' => 'Motorcyclists are very vulnerable at junctions.'],
                    ['text' => 'Pedestrians',     'correct' => false, 'explanation' => 'Pedestrians are among the most vulnerable at junctions.'],
                    ['text' => 'Car drivers',     'correct' => true,  'explanation' => 'Car drivers are the least vulnerable at junctions because they are protected by the vehicle\'s bodywork, airbags and seatbelts.'],
                ],
            ],
            [
                'category' => 'pedestrians-cyclists',
                'difficulty' => 'easy',
                'question' => 'You are about to reverse into a side road when a pedestrian wants to cross behind you. What should you do?',
                'answers' => [
                    ['text' => 'Wave to the pedestrian to stop',                    'correct' => false, 'explanation' => 'You should give way — not try to stop the pedestrian.'],
                    ['text' => 'Give way to the pedestrian',                        'correct' => true,  'explanation' => 'You must give way to any pedestrian crossing the road behind your reversing vehicle.'],
                    ['text' => 'Reverse before the pedestrian starts to cross',    'correct' => false, 'explanation' => 'This is dangerous — reversing near a pedestrian risks a collision.'],
                    ['text' => 'Wave to the pedestrian to cross quickly',           'correct' => false, 'explanation' => 'Do not rush pedestrians — simply wait for them to cross.'],
                ],
            ],
            [
                'category' => 'pedestrians-cyclists',
                'difficulty' => 'medium',
                'question' => 'There is no pedestrian crossing near where you want to cross the road at night. Where should you cross safely?',
                'answers' => [
                    ['text' => 'At any junction',       'correct' => false, 'explanation' => 'A junction improves sightlines but a lighted area is the key safety factor at night.'],
                    ['text' => 'In a lighted area',     'correct' => true,  'explanation' => 'At night, cross in a well-lit area so drivers can see you clearly.'],
                    ['text' => 'Anywhere convenient',   'correct' => false, 'explanation' => 'Crossing without regard to lighting at night is dangerous.'],
                    ['text' => 'On a straight section of road', 'correct' => false, 'explanation' => 'A straight road helps, but a lighted area is the primary safety requirement at night.'],
                ],
            ],
            [
                'category' => 'pedestrians-cyclists',
                'difficulty' => 'easy',
                'question' => 'What should you do when police, ambulance or fire brigade emergency vehicles with sirens and flashing lights are near you?',
                'answers' => [
                    ['text' => 'Slow down slightly',                'correct' => false, 'explanation' => 'Simply slowing down is often insufficient — you must create a clear path.'],
                    ['text' => 'Stop and pull off the road',        'correct' => true,  'explanation' => 'You must pull over to the left and stop to allow emergency vehicles to pass safely.'],
                    ['text' => 'Keep to your left lane only',       'correct' => false, 'explanation' => 'If there is room to pull completely off the road, you should do so.'],
                    ['text' => 'Continue at your normal speed',     'correct' => false, 'explanation' => 'Maintaining speed when an emergency vehicle is approaching hinders its progress.'],
                ],
            ],

            // -------------------------------------------------------
            // LEARNER DRIVERS (PDF additions)
            // -------------------------------------------------------
            [
                'category' => 'learner-drivers',
                'difficulty' => 'medium',
                'question' => 'What is the minimum age a person must be to become a driving instructor in Barbados?',
                'answers' => [
                    ['text' => '19 years', 'correct' => false, 'explanation' => '19 is not the minimum age required.'],
                    ['text' => '20 years', 'correct' => true,  'explanation' => 'A person must be at least 20 years old to become a driving instructor in Barbados.'],
                    ['text' => '25 years', 'correct' => false, 'explanation' => '25 is not the minimum age required.'],
                    ['text' => '18 years', 'correct' => false, 'explanation' => '18 is the minimum age for truck learners, not driving instructors.'],
                ],
            ],
            [
                'category' => 'learner-drivers',
                'difficulty' => 'medium',
                'question' => 'What is the minimum age for a supervisor accompanying a learner driver on the road?',
                'answers' => [
                    ['text' => '19 years', 'correct' => false, 'explanation' => '19 is not the minimum age for a supervisor.'],
                    ['text' => '25 years', 'correct' => false, 'explanation' => '25 is not the stated minimum — it is lower.'],
                    ['text' => '21 years', 'correct' => true,  'explanation' => 'The supervisor accompanying a learner driver must be at least 21 years old.'],
                    ['text' => '28 years', 'correct' => false, 'explanation' => '28 is higher than the required minimum.'],
                ],
            ],
            [
                'category' => 'learner-drivers',
                'difficulty' => 'medium',
                'question' => 'If you are teaching someone to drive in Barbados, how long must you have held a valid licence?',
                'answers' => [
                    ['text' => '1 year',  'correct' => false, 'explanation' => '1 year is not sufficient experience to supervise a learner.'],
                    ['text' => '2 years', 'correct' => false, 'explanation' => '2 years is not the required period.'],
                    ['text' => '5 years', 'correct' => false, 'explanation' => '5 years is longer than the required period.'],
                    ['text' => '3 years', 'correct' => true,  'explanation' => 'You must have held a valid Barbados driver\'s licence for at least 3 years before you may supervise a learner driver.'],
                ],
            ],

            // -------------------------------------------------------
            // VEHICLE LIGHTING (PDF additions)
            // -------------------------------------------------------
            [
                'category' => 'vehicle-lighting',
                'difficulty' => 'easy',
                'question' => 'You are travelling at night and dazzled by headlights coming towards you. What should you do?',
                'answers' => [
                    ['text' => 'Pull down your sun visor',                  'correct' => false, 'explanation' => 'A sun visor does not protect against oncoming headlight glare effectively at night.'],
                    ['text' => 'Slow down or stop',                         'correct' => true,  'explanation' => 'If dazzled by headlights, slow down or stop if necessary — your vision is temporarily impaired.'],
                    ['text' => 'Switch on your main beam headlights',       'correct' => false, 'explanation' => 'Switching to main beam dazzles the oncoming driver, making the situation worse.'],
                    ['text' => 'Put your hand over your eyes',              'correct' => false, 'explanation' => 'Covering your eyes while driving is extremely dangerous.'],
                ],
            ],
            [
                'category' => 'vehicle-lighting',
                'difficulty' => 'medium',
                'question' => 'You may use hazard warning lights when:',
                'answers' => [
                    ['text' => 'Driving slowly in heavy traffic',                        'correct' => false, 'explanation' => 'Hazard lights should not be used while moving in traffic — they confuse other drivers.'],
                    ['text' => 'Driving without headlights in darkness',                 'correct' => false, 'explanation' => 'Hazard lights are not a substitute for headlights.'],
                    ['text' => 'Your vehicle has broken down and temporarily obstructs traffic', 'correct' => true,  'explanation' => 'Hazard warning lights are intended for use when your vehicle is stationary and creating a temporary obstruction.'],
                    ['text' => 'In bad weather while moving',                            'correct' => false, 'explanation' => 'Hazard lights while moving can prevent other drivers from seeing your directional indicators.'],
                ],
            ],

            // -------------------------------------------------------
            // SAFE DRIVING PRACTICES (PDF additions)
            // -------------------------------------------------------
            [
                'category' => 'safe-driving-practices',
                'difficulty' => 'easy',
                'question' => 'Before moving off, what routine should you follow?',
                'answers' => [
                    ['text' => 'Mirror, look, signal, manoeuvre',    'correct' => true,  'explanation' => 'Before moving off you should check your mirrors, look around for hazards, signal your intention, then manoeuvre.'],
                    ['text' => 'Signal, then manoeuvre',             'correct' => false, 'explanation' => 'You must check mirrors and look around before signalling.'],
                    ['text' => 'Manoeuvre, then look',               'correct' => false, 'explanation' => 'You must look before you manoeuvre, not after.'],
                    ['text' => 'Look, then mirror, then manoeuvre',  'correct' => false, 'explanation' => 'The correct order is mirror first, then look, then signal, then manoeuvre.'],
                ],
            ],
            [
                'category' => 'safe-driving-practices',
                'difficulty' => 'easy',
                'question' => 'In good conditions, what is a safe following distance?',
                'answers' => [
                    ['text' => 'One car length for every 10 km/h of speed',   'correct' => true,  'explanation' => 'A safe rule of thumb is one car length for every 10 km/h — so at 60 km/h, keep at least 6 car lengths.'],
                    ['text' => 'One car length at any speed',                  'correct' => false, 'explanation' => 'One car length is only adequate at very low speeds.'],
                    ['text' => 'Two car lengths at any speed',                 'correct' => false, 'explanation' => 'Following distance must increase with speed.'],
                    ['text' => 'Six car lengths at any speed',                 'correct' => false, 'explanation' => 'Following distance must relate to speed, not be fixed.'],
                ],
            ],
            [
                'category' => 'safe-driving-practices',
                'difficulty' => 'medium',
                'question' => 'Radio sounds or harsh noise from a vehicle should not be audible beyond what distance?',
                'answers' => [
                    ['text' => '10 metres (11 yards)', 'correct' => true,  'explanation' => 'The Barbados Highway Code states that radio sounds or harsh noise must not be heard more than 10 metres (11 yards) away from your vehicle.'],
                    ['text' => '25 metres',             'correct' => false, 'explanation' => '25 metres is more than the permitted 10 metres.'],
                    ['text' => '50 metres',             'correct' => false, 'explanation' => '50 metres is far beyond the permitted 10 metre limit.'],
                    ['text' => '5 metres',              'correct' => false, 'explanation' => '5 metres is not the stated maximum — it is 10 metres (11 yards).'],
                ],
            ],
            [
                'category' => 'safe-driving-practices',
                'difficulty' => 'easy',
                'question' => 'Third party insurance does NOT cover:',
                'answers' => [
                    ['text' => 'Injury to another person',          'correct' => false, 'explanation' => 'Third party insurance covers injury to other persons.'],
                    ['text' => 'Damage to someone else\'s property', 'correct' => false, 'explanation' => 'Third party insurance covers damage to third party property.'],
                    ['text' => 'Damage to your own car',            'correct' => true,  'explanation' => 'Third party insurance only covers the other party. It does NOT cover damage to your own vehicle.'],
                    ['text' => 'Damage to the other vehicle',       'correct' => false, 'explanation' => 'Third party insurance covers damage to the other party\'s vehicle.'],
                ],
            ],
            [
                'category' => 'safe-driving-practices',
                'difficulty' => 'easy',
                'question' => 'Who is responsible for the demerit point system in Barbados?',
                'answers' => [
                    ['text' => 'The Court',                 'correct' => false, 'explanation' => 'Courts handle prosecution but do not administer the demerit system.'],
                    ['text' => 'The Police',                'correct' => false, 'explanation' => 'Police enforce the law but do not administer demerit points.'],
                    ['text' => 'The Licensing Authority',   'correct' => true,  'explanation' => 'The Barbados Licensing Authority is responsible for administering the demerit point system.'],
                    ['text' => 'The Ministry of Transport', 'correct' => false, 'explanation' => 'The Ministry sets policy, but the BLA administers the demerit system.'],
                ],
            ],
            [
                'category' => 'safe-driving-practices',
                'difficulty' => 'easy',
                'question' => 'What are demerit points?',
                'answers' => [
                    ['text' => 'Points earned for good driving',                          'correct' => false, 'explanation' => 'Demerit points are not a reward — they are a penalty.'],
                    ['text' => 'Points awarded for passing the driving test',             'correct' => false, 'explanation' => 'The driving test does not award demerit points.'],
                    ['text' => 'Points accumulated by drivers for committing traffic offences', 'correct' => true, 'explanation' => 'Demerit points are penalty points added to a driver\'s record for traffic offences. Accumulating too many can result in licence suspension.'],
                    ['text' => 'Points deducted from your insurance premium',             'correct' => false, 'explanation' => 'Demerit points are a licensing penalty, not an insurance calculation.'],
                ],
            ],
            [
                'category' => 'safe-driving-practices',
                'difficulty' => 'easy',
                'question' => 'If someone wants to overtake you, what should you do?',
                'answers' => [
                    ['text' => 'Speed up to prevent them overtaking',              'correct' => false, 'explanation' => 'Preventing another driver from overtaking is dangerous and illegal.'],
                    ['text' => 'Drop back and make a gap for the overtaking driver', 'correct' => true,  'explanation' => 'If it is safe to do so, drop back and create a gap that makes it easier for the overtaking driver to complete the manoeuvre.'],
                    ['text' => 'Move closer to the car in front',                  'correct' => false, 'explanation' => 'Moving closer to the vehicle ahead reduces the space available for the overtaking manoeuvre.'],
                    ['text' => 'Wave and signal to the driver',                    'correct' => false, 'explanation' => 'Waving can be misinterpreted — the safest action is to drop back and maintain a steady course.'],
                ],
            ],
            [
                'category' => 'safe-driving-practices',
                'difficulty' => 'easy',
                'question' => 'The faster you drive, the more stopping distance and time you need. True or false?',
                'answers' => [
                    ['text' => 'True',   'correct' => true,  'explanation' => 'Stopping distance increases significantly with speed — doubling your speed more than doubles your stopping distance.'],
                    ['text' => 'False',  'correct' => false, 'explanation' => 'This is true — higher speed means greater momentum and longer braking distance.'],
                    ['text' => 'Only on wet roads',          'correct' => false, 'explanation' => 'The relationship between speed and stopping distance applies on all road surfaces.'],
                    ['text' => 'Only above 60 km/h',         'correct' => false, 'explanation' => 'Stopping distance increases proportionally at all speeds.'],
                ],
            ],
            [
                'category' => 'safe-driving-practices',
                'difficulty' => 'medium',
                'question' => 'Following a large goods vehicle too closely is dangerous because:',
                'answers' => [
                    ['text' => 'Your field of vision is reduced',        'correct' => true,  'explanation' => 'Driving close behind a large vehicle dramatically reduces your ability to see the road ahead, hazards, and traffic signs.'],
                    ['text' => 'Slipstreaming reduces wind resistance',  'correct' => false, 'explanation' => 'While slipstreaming can reduce drag, the primary danger is reduced visibility.'],
                    ['text' => 'Your engine will overheat',              'correct' => false, 'explanation' => 'Engine overheating is not caused by following another vehicle.'],
                    ['text' => 'Your brakes need constant cooling',      'correct' => false, 'explanation' => 'Brake cooling is a concern on long descents, not from following a vehicle.'],
                ],
            ],
            [
                'category' => 'safe-driving-practices',
                'difficulty' => 'easy',
                'question' => 'Why should you make sure you cancel your indicator after turning?',
                'answers' => [
                    ['text' => 'To avoid flattening the battery',             'correct' => false, 'explanation' => 'An indicator uses minimal power and will not flatten the battery.'],
                    ['text' => 'To avoid misleading other road users',        'correct' => true,  'explanation' => 'A cancelled indicator tells other road users your turn is complete. Leaving it on misleads drivers and pedestrians about your next intended action.'],
                    ['text' => 'To avoid dazzling other road users',          'correct' => false, 'explanation' => 'Indicators are not bright enough to dazzle.'],
                    ['text' => 'To avoid damaging the indicator relay',       'correct' => false, 'explanation' => 'Modern indicator relays are not damaged by extended use.'],
                ],
            ],
            [
                'category' => 'safe-driving-practices',
                'difficulty' => 'easy',
                'question' => 'What does "defensive driving" mean?',
                'answers' => [
                    ['text' => 'Being alert and always thinking ahead',     'correct' => true,  'explanation' => 'Defensive driving means anticipating hazards, observing all around you, and always planning your response in advance.'],
                    ['text' => 'Always driving slowly and gently',          'correct' => false, 'explanation' => 'Defensive driving is about awareness, not necessarily slow speed.'],
                    ['text' => 'Always letting other drivers go first',     'correct' => false, 'explanation' => 'Yielding unnecessarily can itself cause confusion and accidents.'],
                    ['text' => 'Pulling over for faster traffic',           'correct' => false, 'explanation' => 'Pulling over for faster traffic is courteous but is not the definition of defensive driving.'],
                ],
            ],
            [
                'category' => 'safe-driving-practices',
                'difficulty' => 'easy',
                'question' => 'How does alcohol affect your driving?',
                'answers' => [
                    ['text' => 'It speeds up your reactions',       'correct' => false, 'explanation' => 'Alcohol slows reaction times — it does not speed them up.'],
                    ['text' => 'It increases your awareness',       'correct' => false, 'explanation' => 'Alcohol impairs awareness and judgement.'],
                    ['text' => 'It improves your co-ordination',    'correct' => false, 'explanation' => 'Alcohol significantly reduces co-ordination and motor skills.'],
                    ['text' => 'It reduces your concentration',     'correct' => true,  'explanation' => 'Alcohol reduces concentration, slows reaction times, impairs judgement and reduces co-ordination — all of which make driving dangerous.'],
                ],
            ],
            [
                'category' => 'safe-driving-practices',
                'difficulty' => 'medium',
                'question' => 'The most important factor in avoiding running into the car in front is:',
                'answers' => [
                    ['text' => 'Making sure your brakes are efficient',          'correct' => false, 'explanation' => 'Good brakes help but cannot compensate for following too closely.'],
                    ['text' => 'Always driving at a steady speed',               'correct' => false, 'explanation' => 'A steady speed alone does not prevent rear-end collisions.'],
                    ['text' => 'Keeping the correct separation distance',        'correct' => true,  'explanation' => 'Maintaining a safe gap gives you enough time and distance to stop if the vehicle ahead brakes suddenly.'],
                    ['text' => 'Having tyres that meet legal requirements',      'correct' => false, 'explanation' => 'Good tyres improve braking but are not the primary factor — separation distance is.'],
                ],
            ],
            [
                'category' => 'safe-driving-practices',
                'difficulty' => 'easy',
                'question' => 'To move off safely from a parked position, what should you do last?',
                'answers' => [
                    ['text' => 'Signal if other drivers need to slow down',      'correct' => false, 'explanation' => 'Signalling is important but is not the final check before moving.'],
                    ['text' => 'Give a hand signal as well as using your indicator', 'correct' => false, 'explanation' => 'A hand signal is optional, not the final safety check.'],
                    ['text' => 'Use your mirrors and look around for a final check', 'correct' => true,  'explanation' => 'Before finally moving off, use your mirrors and look around — especially in your blind spots — for a final check that it is safe.'],
                    ['text' => 'Rev the engine to warm it up',                   'correct' => false, 'explanation' => 'Revving the engine is unnecessary and not a safety check.'],
                ],
            ],
            [
                'category' => 'safe-driving-practices',
                'difficulty' => 'easy',
                'question' => 'A driver attends a social event. What precaution should they take?',
                'answers' => [
                    ['text' => 'Drink plenty of coffee before driving',             'correct' => false, 'explanation' => 'Coffee does not sufficiently reduce blood alcohol to safe driving levels.'],
                    ['text' => 'Avoid busy roads after drinking alcohol',            'correct' => false, 'explanation' => 'Alcohol impairs driving on all roads, not just busy ones.'],
                    ['text' => 'Avoid drinking alcohol completely',                  'correct' => true,  'explanation' => 'The only safe option if driving is to avoid alcohol completely. Any amount of alcohol affects your ability to drive safely.'],
                    ['text' => 'Avoid drinking on an empty stomach',                'correct' => false, 'explanation' => 'Eating food slows alcohol absorption but does not make drinking and driving safe.'],
                ],
            ],
            [
                'category' => 'safe-driving-practices',
                'difficulty' => 'easy',
                'question' => 'What should you use your horn for?',
                'answers' => [
                    ['text' => 'To alert others to your presence',    'correct' => true,  'explanation' => 'The horn is a warning device — use it to alert other road users to your presence when necessary for safety.'],
                    ['text' => 'To claim your right of way',          'correct' => false, 'explanation' => 'Sounding your horn does not grant you right of way.'],
                    ['text' => 'To greet other road users',           'correct' => false, 'explanation' => 'Using your horn to greet others is a misuse of the device.'],
                    ['text' => 'To signal your annoyance',            'correct' => false, 'explanation' => 'Using your horn to express anger or frustration is prohibited.'],
                ],
            ],
            [
                'category' => 'safe-driving-practices',
                'difficulty' => 'medium',
                'question' => 'Why is pressing the clutch down for long periods a bad habit?',
                'answers' => [
                    ['text' => 'It reduces the car\'s speed when going downhill',    'correct' => false, 'explanation' => 'Holding the clutch on a downhill reduces engine braking but does not directly cause loss of control.'],
                    ['text' => 'It causes the engine to wear out more quickly',       'correct' => false, 'explanation' => 'Engine wear is not the primary reason.'],
                    ['text' => 'It reduces the driver\'s control of the vehicle',     'correct' => true,  'explanation' => 'With the clutch depressed, the engine is disconnected from the drive wheels, reducing engine braking and making the car harder to control, especially on bends or when slowing.'],
                    ['text' => 'It causes the engine to use more fuel',               'correct' => false, 'explanation' => 'Holding the clutch does not directly cause increased fuel consumption.'],
                ],
            ],
            [
                'category' => 'safe-driving-practices',
                'difficulty' => 'medium',
                'question' => 'You are at a junction with limited visibility. What should you do?',
                'answers' => [
                    ['text' => 'Inch forward, looking to the right only',  'correct' => false, 'explanation' => 'You must check both directions at any junction.'],
                    ['text' => 'Inch forward, looking to the left only',   'correct' => false, 'explanation' => 'You must check both directions, not just left.'],
                    ['text' => 'Inch forward, looking both ways',          'correct' => true,  'explanation' => 'At a junction with poor visibility, creep forward slowly while looking carefully in both directions until you can safely see if it is clear to proceed.'],
                    ['text' => 'Be ready to move off quickly',             'correct' => false, 'explanation' => 'Moving quickly at a blind junction is extremely dangerous.'],
                ],
            ],
            [
                'category' => 'safe-driving-practices',
                'difficulty' => 'easy',
                'question' => 'You are driving in traffic at the speed limit and the driver behind is trying to overtake. What should you do?',
                'answers' => [
                    ['text' => 'Move closer to the car ahead to prevent them passing',    'correct' => false, 'explanation' => 'Blocking an overtaking vehicle is dangerous and illegal.'],
                    ['text' => 'Wave the driver behind to overtake when you think it is safe', 'correct' => false, 'explanation' => 'It is not your responsibility to direct others to overtake — you could misjudge the conditions.'],
                    ['text' => 'Keep a steady course and allow the driver to overtake',   'correct' => true,  'explanation' => 'Maintain your speed and road position. The driver behind is responsible for completing the overtake safely.'],
                    ['text' => 'Accelerate to get away from the driver behind',           'correct' => false, 'explanation' => 'Speeding up to prevent an overtake is dangerous and illegal.'],
                ],
            ],
            [
                'category' => 'safe-driving-practices',
                'difficulty' => 'medium',
                'question' => 'Which side of the road should a marching band travel on?',
                'answers' => [
                    ['text' => 'Right side, facing oncoming traffic',   'correct' => false, 'explanation' => 'Individual pedestrians walk on the right, but organised groups march on the left.'],
                    ['text' => 'Left side, with traffic',               'correct' => true,  'explanation' => 'An organised marching band or procession should keep to the left side of the road, in the same direction as traffic flow.'],
                    ['text' => 'Centre of the road',                    'correct' => false, 'explanation' => 'The centre of the road is not a safe position for any road user.'],
                    ['text' => 'Either side, depending on visibility',  'correct' => false, 'explanation' => 'There is a defined rule — left side for organised marches.'],
                ],
            ],
            [
                'category' => 'safe-driving-practices',
                'difficulty' => 'easy',
                'question' => 'Tinted spectacles should not be worn:',
                'answers' => [
                    ['text' => 'At night only',                                      'correct' => false, 'explanation' => 'Tinted spectacles should also be avoided in any conditions of poor visibility.'],
                    ['text' => 'At night or in conditions of poor visibility',       'correct' => true,  'explanation' => 'Tinted lenses reduce the amount of light reaching your eyes — at night or in poor visibility they significantly reduce your ability to see clearly.'],
                    ['text' => 'In poor visibility only',                            'correct' => false, 'explanation' => 'Night-time is also included — both conditions apply.'],
                    ['text' => 'Only on motorways',                                  'correct' => false, 'explanation' => 'The restriction applies in all conditions of poor visibility or darkness, not just motorways.'],
                ],
            ],
            [
                'category' => 'safe-driving-practices',
                'difficulty' => 'easy',
                'question' => 'You have signalled a bus to stop but it is raining. What should you do?',
                'answers' => [
                    ['text' => 'Board as quickly as possible',                      'correct' => false, 'explanation' => 'Rushing onto a bus in wet conditions increases the risk of slipping.'],
                    ['text' => 'Wait until the bus has fully stopped before boarding', 'correct' => true, 'explanation' => 'Always wait until the bus has come to a complete stop before attempting to board, even in wet weather.'],
                    ['text' => 'Step into the road to make the driver stop sooner', 'correct' => false, 'explanation' => 'Stepping into the road to stop a bus is extremely dangerous.'],
                    ['text' => 'Wave the bus past and wait for the next one',       'correct' => false, 'explanation' => 'There is no need to miss the bus — simply wait for it to stop fully.'],
                ],
            ],
            [
                'category' => 'safe-driving-practices',
                'difficulty' => 'medium',
                'question' => 'If a disabled vehicle must be towed without a tow truck, who may drive the disabled vehicle?',
                'answers' => [
                    ['text' => 'Only a licensed driver',                            'correct' => true,  'explanation' => 'Only a person holding a valid driver\'s licence may operate a vehicle being towed on the road.'],
                    ['text' => 'Only the owner of the disabled vehicle',            'correct' => false, 'explanation' => 'The owner does not need to drive it — any licensed driver may.'],
                    ['text' => 'Only a driver licenced for at least three years',   'correct' => false, 'explanation' => 'There is no minimum duration of licence specified — just that the driver must be licensed.'],
                    ['text' => 'Anyone who knows how to drive',                     'correct' => false, 'explanation' => 'Knowing how to drive is not the same as holding a valid licence.'],
                ],
            ],
            [
                'category' => 'safe-driving-practices',
                'difficulty' => 'easy',
                'question' => 'You should not start a journey if:',
                'answers' => [
                    ['text' => 'You did not first drink some black coffee',   'correct' => false, 'explanation' => 'Coffee is not a legal or safety requirement before driving.'],
                    ['text' => 'You cannot consult your doctor first',         'correct' => false, 'explanation' => 'A doctor\'s consultation is not required before every journey.'],
                    ['text' => 'You are feeling tired',                        'correct' => true,  'explanation' => 'Driving when tired is extremely dangerous. Fatigue impairs reactions, concentration and judgement — do not start a journey if you feel tired.'],
                    ['text' => 'The weather is poor',                          'correct' => false, 'explanation' => 'Poor weather does not automatically mean you should not travel, though you must adjust your driving.'],
                ],
            ],
            [
                'category' => 'safe-driving-practices',
                'difficulty' => 'easy',
                'question' => 'If you are the first to arrive at the scene of an accident, which of these should you NOT do?',
                'answers' => [
                    ['text' => 'Leave as soon as another motorist arrives',       'correct' => true,  'explanation' => 'You should not leave just because another person arrives. Stay until the emergency services arrive and give all the help you can.'],
                    ['text' => 'Switch off the vehicle engine(s)',                'correct' => false, 'explanation' => 'Switching off engines is correct — it reduces fire risk.'],
                    ['text' => 'Call emergency services',                         'correct' => false, 'explanation' => 'Calling emergency services is one of the first things you should do.'],
                    ['text' => 'Warn approaching traffic',                        'correct' => false, 'explanation' => 'Warning other traffic is important to prevent further collisions.'],
                ],
            ],

            // -------------------------------------------------------
            // ANIMALS ON THE ROAD (PDF additions)
            // -------------------------------------------------------
            [
                'category' => 'animals-on-the-road',
                'difficulty' => 'medium',
                'question' => 'When leading a horse on the road, which side should you keep it on?',
                'answers' => [
                    ['text' => 'Keep it on your left, between you and the traffic',   'correct' => false, 'explanation' => 'Placing the horse between yourself and traffic puts the animal in the direct path of vehicles.'],
                    ['text' => 'Keep it on your right, with you between it and traffic', 'correct' => true,  'explanation' => 'You should keep the horse on your right so that you are between the horse and oncoming traffic, protecting both yourself and the animal.'],
                    ['text' => 'Let it walk freely on either side',                   'correct' => false, 'explanation' => 'An animal allowed to wander freely is an unpredictable hazard.'],
                    ['text' => 'Always walk it on the right-hand side of the road',   'correct' => false, 'explanation' => 'The position relative to the handler matters — keep horse on your right.'],
                ],
            ],

            // -------------------------------------------------------
            // ROAD SIGNS (Quizlet PDF additions)
            // -------------------------------------------------------
            [
                'category' => 'road-signs',
                'difficulty' => 'easy',
                'question' => 'What does a circular sign with a red border showing a left-turn arrow crossed out mean?',
                'answers' => [
                    ['text' => 'No left turn',   'correct' => true,  'explanation' => 'A circular red-border sign with a crossed-out left-turn arrow prohibits vehicles from turning left.'],
                    ['text' => 'No right turn',  'correct' => false, 'explanation' => 'No right turn would show a right-turn arrow crossed out.'],
                    ['text' => 'Turn left ahead', 'correct' => false, 'explanation' => 'Turn left ahead is a blue circular mandatory sign, not a red-bordered prohibition.'],
                    ['text' => 'No U turns',      'correct' => false, 'explanation' => 'No U-turn shows a U-shaped arrow crossed out.'],
                ],
            ],
            [
                'category' => 'road-signs',
                'difficulty' => 'easy',
                'question' => 'What does a circular sign with a red border showing a right-turn arrow crossed out mean?',
                'answers' => [
                    ['text' => 'No right turn',  'correct' => true,  'explanation' => 'A circular red-border sign with a crossed-out right-turn arrow prohibits vehicles from turning right.'],
                    ['text' => 'No left turn',   'correct' => false, 'explanation' => 'No left turn would show a left-turn arrow crossed out.'],
                    ['text' => 'Turn right ahead', 'correct' => false, 'explanation' => 'Turn right ahead is a blue circular mandatory sign, not a red-bordered prohibition.'],
                    ['text' => 'No entry',        'correct' => false, 'explanation' => 'No entry is a red circle with a white horizontal bar.'],
                ],
            ],
            [
                'category' => 'road-signs',
                'difficulty' => 'easy',
                'question' => 'What does a circular sign with a red border showing a U-shaped arrow crossed out mean?',
                'answers' => [
                    ['text' => 'No U turns',     'correct' => true,  'explanation' => 'A circular red-border sign with a U-shaped arrow crossed out prohibits U-turns.'],
                    ['text' => 'No overtaking',  'correct' => false, 'explanation' => 'No overtaking shows two cars side by side, not a U-shaped arrow.'],
                    ['text' => 'No left turn',   'correct' => false, 'explanation' => 'No left turn shows a left-turn arrow crossed out.'],
                    ['text' => 'No right turn',  'correct' => false, 'explanation' => 'No right turn shows a right-turn arrow crossed out.'],
                ],
            ],
            [
                'category' => 'road-signs',
                'difficulty' => 'medium',
                'question' => 'What does a circular sign with a red border showing both a motorcycle above a car mean?',
                'answers' => [
                    ['text' => 'No motor vehicles',   'correct' => true,  'explanation' => 'A circular red-border sign showing a motorcycle above a car prohibits all motor vehicles from entering.'],
                    ['text' => 'Motor vehicles only', 'correct' => false, 'explanation' => 'A motor vehicles only sign would be blue, not red-bordered.'],
                    ['text' => 'No cycling',           'correct' => false, 'explanation' => 'No cycling shows only a bicycle symbol in a red circle.'],
                    ['text' => 'No overtaking',        'correct' => false, 'explanation' => 'No overtaking shows two cars side by side — one red, one black.'],
                ],
            ],
            [
                'category' => 'road-signs',
                'difficulty' => 'easy',
                'question' => 'What does a triangular warning sign with a T-shape inside mean?',
                'answers' => [
                    ['text' => 'T-junction ahead',    'correct' => true,  'explanation' => 'A triangular sign with a T-shape warns of a T-junction ahead — the main road meets a side road.'],
                    ['text' => 'Crossroads ahead',    'correct' => false, 'explanation' => 'Crossroads ahead shows a cross (+) shape inside the triangle.'],
                    ['text' => 'Staggered junction',  'correct' => false, 'explanation' => 'A staggered junction sign shows an offset cross inside the triangle.'],
                    ['text' => 'Side road junction',  'correct' => false, 'explanation' => 'A side road sign shows a junction with one side arm offset.'],
                ],
            ],
            [
                'category' => 'road-signs',
                'difficulty' => 'medium',
                'question' => 'A triangular warning sign with an offset cross (one arm shifted to the side) indicates:',
                'answers' => [
                    ['text' => 'Staggered junction ahead', 'correct' => true,  'explanation' => 'An offset cross in a warning triangle indicates a staggered junction — the side roads do not align directly opposite each other.'],
                    ['text' => 'Crossroads ahead',         'correct' => false, 'explanation' => 'A crossroads sign shows a straight cross, not an offset one.'],
                    ['text' => 'T-junction ahead',         'correct' => false, 'explanation' => 'A T-junction sign shows a T-shape, not a cross.'],
                    ['text' => 'Roundabout ahead',         'correct' => false, 'explanation' => 'A roundabout sign shows three arrows in a circle.'],
                ],
            ],
            [
                'category' => 'road-signs',
                'difficulty' => 'medium',
                'question' => 'A triangular warning sign showing traffic merging in from the right side means:',
                'answers' => [
                    ['text' => 'Merging traffic ahead', 'correct' => true,  'explanation' => 'This sign warns that traffic from a side road or slip road will be merging into your lane from the right.'],
                    ['text' => 'Side road junction',    'correct' => false, 'explanation' => 'A side road sign indicates a junction, not necessarily merging.'],
                    ['text' => 'Dual carriageway ends', 'correct' => false, 'explanation' => 'Dual carriageway ending shows two parallel lanes converging into one.'],
                    ['text' => 'Road narrows',          'correct' => false, 'explanation' => 'Road narrows shows the road width reducing symmetrically from both or one side.'],
                ],
            ],
            [
                'category' => 'road-signs',
                'difficulty' => 'easy',
                'question' => 'What does a triangular warning sign with a curved arrow (bend shape) inside mean?',
                'answers' => [
                    ['text' => 'Bend ahead',         'correct' => true,  'explanation' => 'A triangular sign with a curved arrow warns of a bend ahead in the road.'],
                    ['text' => 'Double bend',         'correct' => false, 'explanation' => 'A double bend sign shows an S-shaped arrow that reverses direction.'],
                    ['text' => 'Roundabout ahead',    'correct' => false, 'explanation' => 'A roundabout sign shows three circling arrows.'],
                    ['text' => 'Slippery road ahead', 'correct' => false, 'explanation' => 'Slippery road shows a skidding car, not a bend arrow.'],
                ],
            ],
            [
                'category' => 'road-signs',
                'difficulty' => 'easy',
                'question' => 'What does a triangular warning sign with an S-shaped arrow inside mean?',
                'answers' => [
                    ['text' => 'Double bend ahead',  'correct' => true,  'explanation' => 'An S-shaped arrow in a warning triangle indicates two bends in quick succession — a double bend.'],
                    ['text' => 'Single bend ahead',  'correct' => false, 'explanation' => 'A single bend sign shows a simple curved arrow, not an S-shape.'],
                    ['text' => 'Road narrows',        'correct' => false, 'explanation' => 'Road narrows shows the road width decreasing, not bends.'],
                    ['text' => 'Winding road',        'correct' => false, 'explanation' => 'A double bend sign specifically warns of two bends — not a general winding road.'],
                ],
            ],
            [
                'category' => 'road-signs',
                'difficulty' => 'easy',
                'question' => 'A triangular warning sign showing two lines converging equally from both sides indicates:',
                'answers' => [
                    ['text' => 'Road narrows ahead',          'correct' => true,  'explanation' => 'Two lines converging equally from both sides in a warning triangle means the road narrows from both sides ahead.'],
                    ['text' => 'Road narrows on one side',    'correct' => false, 'explanation' => 'When the road narrows on one side only, just one line converges inward.'],
                    ['text' => 'Dual carriageway ends',       'correct' => false, 'explanation' => 'Dual carriageway ending shows two lanes merging into one, not both sides of the road closing in.'],
                    ['text' => 'Merging traffic',             'correct' => false, 'explanation' => 'Merging traffic shows a side road joining, not the road itself narrowing.'],
                ],
            ],
            [
                'category' => 'road-signs',
                'difficulty' => 'easy',
                'question' => 'A triangular warning sign with a bumpy (uneven) surface symbol inside means:',
                'answers' => [
                    ['text' => 'Uneven road ahead',   'correct' => true,  'explanation' => 'A humpy or bumpy surface symbol in a warning triangle warns of an uneven road surface ahead — reduce speed.'],
                    ['text' => 'Road hump ahead',     'correct' => false, 'explanation' => 'A road hump sign shows a single smooth rounded hump, not a rough surface.'],
                    ['text' => 'Slippery road',       'correct' => false, 'explanation' => 'Slippery road shows a car with skid marks, not bumps.'],
                    ['text' => 'Road works ahead',    'correct' => false, 'explanation' => 'Road works shows a worker with a shovel, not road surface bumps.'],
                ],
            ],
            [
                'category' => 'road-signs',
                'difficulty' => 'medium',
                'question' => 'What does a blue circular sign with a red diagonal stripe mean?',
                'answers' => [
                    ['text' => 'No waiting',               'correct' => true,  'explanation' => 'A blue circular sign with a red diagonal stripe means no waiting — you may not stop and wait on that section of road.'],
                    ['text' => 'No stopping on carriageway', 'correct' => false, 'explanation' => 'No stopping is shown by a blue circle with a red X, not a single diagonal stripe.'],
                    ['text' => 'No overtaking',            'correct' => false, 'explanation' => 'No overtaking shows two cars side by side in a red-border circle.'],
                    ['text' => 'End of speed limit',       'correct' => false, 'explanation' => 'End of speed limit is a white circle with a single diagonal black stripe.'],
                ],
            ],
            [
                'category' => 'road-signs',
                'difficulty' => 'medium',
                'question' => 'What does a blue circular sign with a red X crossed through it mean?',
                'answers' => [
                    ['text' => 'No stopping on carriageway', 'correct' => true,  'explanation' => 'A blue circle with a red X prohibits stopping on the carriageway at any time.'],
                    ['text' => 'No waiting',                 'correct' => false, 'explanation' => 'No waiting uses a blue circle with a single red diagonal stripe, not an X.'],
                    ['text' => 'No entry',                   'correct' => false, 'explanation' => 'No entry is a red circle with a white horizontal bar.'],
                    ['text' => 'No U turns',                 'correct' => false, 'explanation' => 'No U turns shows a U-shaped arrow crossed out in a red-border circle.'],
                ],
            ],
            [
                'category' => 'road-signs',
                'difficulty' => 'easy',
                'question' => 'What does a blue circular sign with a white downward-left diagonal arrow mean?',
                'answers' => [
                    ['text' => 'Keep left',     'correct' => true,  'explanation' => 'A blue circle with a downward-left white arrow is a mandatory instruction to keep to the left side of an obstruction (e.g. a bollard or roundabout).'],
                    ['text' => 'Turn left ahead', 'correct' => false, 'explanation' => 'Turn left ahead shows a bent left-curving arrow, not a diagonal one.'],
                    ['text' => 'No left turn',  'correct' => false, 'explanation' => 'No left turn has a red border and shows a left-turn arrow crossed out.'],
                    ['text' => 'Keep right',    'correct' => false, 'explanation' => 'Keep right would show a downward-right diagonal arrow.'],
                ],
            ],
            [
                'category' => 'road-signs',
                'difficulty' => 'easy',
                'question' => 'A blue circular sign with a white upward arrow means:',
                'answers' => [
                    ['text' => 'Ahead only — proceed straight on', 'correct' => true,  'explanation' => 'A blue circle with a white upward arrow is a mandatory sign ordering drivers to proceed straight ahead only.'],
                    ['text' => 'One way traffic',                  'correct' => false, 'explanation' => 'One way traffic is typically a rectangular blue sign, not a circular one.'],
                    ['text' => 'Road clear ahead',                 'correct' => false, 'explanation' => 'There is no road-clear-ahead sign.'],
                    ['text' => 'Highway entrance',                 'correct' => false, 'explanation' => 'Highway entrance signs are rectangular and directional.'],
                ],
            ],
            [
                'category' => 'road-signs',
                'difficulty' => 'easy',
                'question' => 'What does a blue circular sign with a white left-curving arrow mean?',
                'answers' => [
                    ['text' => 'Turn left ahead',  'correct' => true,  'explanation' => 'A blue circle with a white left-curving arrow is a mandatory sign ordering drivers to turn left at the next point.'],
                    ['text' => 'No left turn',     'correct' => false, 'explanation' => 'No left turn has a red border and shows a crossed-out left-turn arrow.'],
                    ['text' => 'Keep left',        'correct' => false, 'explanation' => 'Keep left shows a downward-left diagonal arrow, not a curving turn arrow.'],
                    ['text' => 'Road bends left',  'correct' => false, 'explanation' => 'Road bend warnings are triangular signs, not blue circles.'],
                ],
            ],
            [
                'category' => 'road-signs',
                'difficulty' => 'easy',
                'question' => 'What does a rectangular blue sign with a white upward arrow indicate?',
                'answers' => [
                    ['text' => 'One way traffic',   'correct' => true,  'explanation' => 'A rectangular blue sign with a white upward arrow marks a one-way street — traffic flows in one direction only.'],
                    ['text' => 'Ahead only',         'correct' => false, 'explanation' => 'Ahead only is a circular blue sign, not rectangular.'],
                    ['text' => 'No entry',           'correct' => false, 'explanation' => 'No entry is a red circle with a white horizontal bar.'],
                    ['text' => 'Highway ahead',      'correct' => false, 'explanation' => 'Highway signs use different colours and are directional, not a white-arrow-on-blue rectangle.'],
                ],
            ],
            [
                'category' => 'road-signs',
                'difficulty' => 'medium',
                'question' => 'What does a white circular sign with a single black diagonal stripe mean?',
                'answers' => [
                    ['text' => 'End of speed limit', 'correct' => true,  'explanation' => 'A white circle with a single diagonal stripe indicates the end of a speed restriction — normal speed limits now apply.'],
                    ['text' => 'No waiting',          'correct' => false, 'explanation' => 'No waiting uses a blue circular sign with a red diagonal stripe.'],
                    ['text' => 'No overtaking',       'correct' => false, 'explanation' => 'No overtaking shows two cars side by side in a red-border circle.'],
                    ['text' => 'Road closed',         'correct' => false, 'explanation' => 'Road closed signs use different designs.'],
                ],
            ],
            [
                'category' => 'road-signs',
                'difficulty' => 'medium',
                'question' => 'A triangular warning sign showing two lanes of traffic converging into one indicates:',
                'answers' => [
                    ['text' => 'Dual carriageway ends ahead', 'correct' => true,  'explanation' => 'Two parallel lanes converging into one in a warning triangle means the dual carriageway ends — prepare to merge into a single road.'],
                    ['text' => 'Road narrows ahead',          'correct' => false, 'explanation' => 'Road narrows shows both sides of the road converging, not necessarily a dual carriageway ending.'],
                    ['text' => 'Merging traffic',             'correct' => false, 'explanation' => 'Merging traffic shows a side road joining, not a dual carriageway ending.'],
                    ['text' => 'Two-way traffic ahead',       'correct' => false, 'explanation' => 'Two-way traffic signs show two opposing arrows, not merging lanes.'],
                ],
            ],
            [
                'category' => 'road-signs',
                'difficulty' => 'easy',
                'question' => 'In Barbados, what shape is the pedestrian crossing sign (at the crossing itself)?',
                'answers' => [
                    ['text' => 'Yellow diamond with a pedestrian figure', 'correct' => true,  'explanation' => 'In Barbados, the pedestrian crossing sign is a yellow diamond shape with a pedestrian figure — different from the triangular UK-style sign.'],
                    ['text' => 'Red triangle with a pedestrian figure',   'correct' => false, 'explanation' => 'A triangular pedestrian figure sign is used as a warning of a crossing ahead, not the crossing marker itself.'],
                    ['text' => 'Blue rectangle with a pedestrian figure', 'correct' => false, 'explanation' => 'Blue rectangles are informational, not used for pedestrian crossing warnings.'],
                    ['text' => 'Red circle with a pedestrian figure',     'correct' => false, 'explanation' => 'Red circles give prohibitions, not crossing warnings.'],
                ],
            ],
            [
                'category' => 'road-signs',
                'difficulty' => 'easy',
                'question' => 'What does a triangular warning sign containing a traffic light symbol mean?',
                'answers' => [
                    ['text' => 'Traffic signals ahead',      'correct' => true,  'explanation' => 'A warning triangle containing a traffic light symbol warns drivers that traffic signals are ahead — be prepared to stop.'],
                    ['text' => 'Traffic light is faulty',    'correct' => false, 'explanation' => 'A faulty light is not indicated by a road sign — it would be obvious from the malfunctioning signal itself.'],
                    ['text' => 'Stop and check for signals', 'correct' => false, 'explanation' => 'This is a warning sign, not an instruction to stop.'],
                    ['text' => 'Controlled junction',        'correct' => false, 'explanation' => 'The specific sign for approaching traffic lights is "traffic signals ahead", not "controlled junction".'],
                ],
            ],
            [
                'category' => 'road-signs',
                'difficulty' => 'medium',
                'question' => 'A triangular warning sign containing only an exclamation mark (!) means:',
                'answers' => [
                    ['text' => 'Other danger ahead — hazard not covered by another sign', 'correct' => true,  'explanation' => 'A warning triangle with only an exclamation mark indicates a danger not covered by specific signs — look out for local hazards.'],
                    ['text' => 'Speed cameras ahead',   'correct' => false, 'explanation' => 'Speed cameras have their own specific sign design.'],
                    ['text' => 'Hazardous chemicals',   'correct' => false, 'explanation' => 'Hazardous materials use specific diamond-shaped symbols, not a plain exclamation mark in a triangle.'],
                    ['text' => 'Stop and look',         'correct' => false, 'explanation' => 'This is a warning sign, not a mandatory stop instruction.'],
                ],
            ],
            [
                'category' => 'road-signs',
                'difficulty' => 'easy',
                'question' => 'What does a rectangular red sign reading "REDUCE SPEED NOW" mean?',
                'answers' => [
                    ['text' => 'You must slow down immediately',   'correct' => true,  'explanation' => '"Reduce Speed Now" is a mandatory instruction to slow down — often used before hazards, schools, or congested areas.'],
                    ['text' => 'The speed limit has changed',      'correct' => false, 'explanation' => 'A speed limit change uses a circular speed limit sign, not "Reduce Speed Now".'],
                    ['text' => 'Road works are ahead',             'correct' => false, 'explanation' => 'Road works have their own warning sign (worker with shovel in a triangle).'],
                    ['text' => 'The road ahead is closed',         'correct' => false, 'explanation' => 'Road closure signs use different designs and wording.'],
                ],
            ],
            [
                'category' => 'road-signs',
                'difficulty' => 'easy',
                'question' => 'A triangular warning sign showing a worker with a shovel indicates:',
                'answers' => [
                    ['text' => 'Road works ahead',      'correct' => true,  'explanation' => 'A worker with a shovel inside a warning triangle is the standard road works ahead sign — slow down and watch for workers and changed road conditions.'],
                    ['text' => 'Rough road ahead',      'correct' => false, 'explanation' => 'An uneven road sign shows bumps, not a worker figure.'],
                    ['text' => 'Diversion ahead',       'correct' => false, 'explanation' => 'Diversion signs are rectangular with directional arrows.'],
                    ['text' => 'Pedestrians ahead',     'correct' => false, 'explanation' => 'A pedestrian warning shows a walking figure without a shovel.'],
                ],
            ],
            [
                'category' => 'road-signs',
                'difficulty' => 'easy',
                'question' => 'A triangular warning sign showing a car with skid marks leaving the road means:',
                'answers' => [
                    ['text' => 'Slippery road ahead',  'correct' => true,  'explanation' => 'A skidding car in a warning triangle warns of a slippery road surface ahead — reduce speed and drive with extra care.'],
                    ['text' => 'Accident blackspot',   'correct' => false, 'explanation' => 'Accident blackspot signs have a different specific design.'],
                    ['text' => 'Road humps ahead',     'correct' => false, 'explanation' => 'Road humps show a rounded hump, not a skidding car.'],
                    ['text' => 'Uneven road',          'correct' => false, 'explanation' => 'Uneven road shows bumps, not a skidding vehicle.'],
                ],
            ],
            [
                'category' => 'road-signs',
                'difficulty' => 'easy',
                'question' => 'A triangular warning sign with a single rounded hump inside means:',
                'answers' => [
                    ['text' => 'Road hump ahead',      'correct' => true,  'explanation' => 'A rounded hump in a warning triangle indicates a road hump (speed bump) ahead — slow down to avoid damage.'],
                    ['text' => 'Uneven road ahead',    'correct' => false, 'explanation' => 'Uneven road shows multiple bumps, not a single smooth hump.'],
                    ['text' => 'Slippery road ahead',  'correct' => false, 'explanation' => 'Slippery road shows a skidding car, not a hump.'],
                    ['text' => 'Sharp deviation',      'correct' => false, 'explanation' => 'Sharp deviation shows chevron arrows, not a hump.'],
                ],
            ],
            [
                'category' => 'road-signs',
                'difficulty' => 'medium',
                'question' => 'A triangular warning sign showing a car falling off a cliff edge into water warns of:',
                'answers' => [
                    ['text' => 'Quayside or river bank ahead', 'correct' => true,  'explanation' => 'This sign warns that the road edge drops into water — a quayside, river bank, or similar hazard is nearby.'],
                    ['text' => 'Flood risk ahead',             'correct' => false, 'explanation' => 'A flood risk sign would show a flooded road, not a car falling into water.'],
                    ['text' => 'Steep descent',                'correct' => false, 'explanation' => 'A steep descent sign shows an incline with a percentage gradient.'],
                    ['text' => 'Bridge ahead',                 'correct' => false, 'explanation' => 'Bridge signs are rectangular or directional, not triangular car-into-water warnings.'],
                ],
            ],
            [
                'category' => 'road-signs',
                'difficulty' => 'medium',
                'question' => 'What does an area enclosed by a solid yellow line on the road mean?',
                'answers' => [
                    ['text' => 'Do not enter the area except in an emergency', 'correct' => true,  'explanation' => 'A solid yellow box/line enclosing an area means vehicles must not enter or stop inside it, except in an emergency.'],
                    ['text' => 'No parking in this area',                      'correct' => false, 'explanation' => 'No parking is shown by specific parking restriction signs, not a yellow box.'],
                    ['text' => 'A pedestrian zone',                            'correct' => false, 'explanation' => 'Pedestrian zones have their own specific signs and markings.'],
                    ['text' => 'A bus stop area',                              'correct' => false, 'explanation' => 'Bus stops have their own specific markings — not a solid yellow enclosure.'],
                ],
            ],

            // -------------------------------------------------------
            // PEDESTRIANS & CYCLISTS (Quizlet PDF additions)
            // -------------------------------------------------------
            [
                'category' => 'pedestrians-cyclists',
                'difficulty' => 'easy',
                'question' => 'When walking in particularly heavy traffic, how should pedestrians arrange themselves?',
                'answers' => [
                    ['text' => 'In single file',                     'correct' => true,  'explanation' => 'In particularly heavy traffic, pedestrians should walk in single file to minimise the space they occupy on the road.'],
                    ['text' => 'Two abreast',                        'correct' => false, 'explanation' => 'Walking two abreast in heavy traffic takes up more road space and is less safe.'],
                    ['text' => 'Side by side in groups',             'correct' => false, 'explanation' => 'Grouping side by side in heavy traffic is dangerous — single file is required.'],
                    ['text' => 'Spread across the full road width',  'correct' => false, 'explanation' => 'Spreading across the road in heavy traffic is extremely dangerous.'],
                ],
            ],
            [
                'category' => 'pedestrians-cyclists',
                'difficulty' => 'easy',
                'question' => 'In dark or poor light conditions, what should a pedestrian do to be more visible (especially when there is no sidewalk)?',
                'answers' => [
                    ['text' => 'Wear or carry something white, light-coloured or reflective', 'correct' => true,  'explanation' => 'In poor light or darkness, pedestrians should wear or carry white, light-coloured or reflective items so drivers can see them more easily.'],
                    ['text' => 'Walk faster to spend less time on the road',                  'correct' => false, 'explanation' => 'Walking faster does not improve visibility to drivers.'],
                    ['text' => 'Walk on the left side of the road',                           'correct' => false, 'explanation' => 'Wearing white/reflective clothing is the key safety measure — the correct side for pedestrians remains the right (facing traffic).'],
                    ['text' => 'Carry a loud whistle',                                        'correct' => false, 'explanation' => 'A whistle does not improve visibility — wearing reflective or light clothing does.'],
                ],
            ],
            [
                'category' => 'pedestrians-cyclists',
                'difficulty' => 'medium',
                'question' => 'What should participants in organised road walks do in general?',
                'answers' => [
                    ['text' => 'Keep to the left, with lookouts at the front and back carrying a warning paddle or sign', 'correct' => true,  'explanation' => 'Organised walks should keep to the left side of the road, with lookouts at both front and rear of the group carrying a warning paddle or sign.'],
                    ['text' => 'Walk on the right side to face oncoming traffic',                                         'correct' => false, 'explanation' => 'Individual pedestrians walk on the right, but organised groups should keep to the left.'],
                    ['text' => 'Walk in the centre of the road',                                                          'correct' => false, 'explanation' => 'The centre of the road is not safe for organised walks.'],
                    ['text' => 'Walk only on footpaths',                                                                  'correct' => false, 'explanation' => 'Footpaths may not always be available — these rules apply when using the road.'],
                ],
            ],
            [
                'category' => 'pedestrians-cyclists',
                'difficulty' => 'medium',
                'question' => 'At night, what lighting is required for an organised road walk?',
                'answers' => [
                    ['text' => 'Front lookout carries a white light, rear lookout carries a red light, outer rank wears reflective clothing', 'correct' => true,  'explanation' => 'The front lookout carries a white light, the rear lookout a bright red light, the outer rank wears reflective clothes, and additional lights should be carried.'],
                    ['text' => 'All participants carry white lights',                                                                          'correct' => false, 'explanation' => 'Different lights are required for different positions — white at front, red at back.'],
                    ['text' => 'Only the group leader needs a torch',                                                                          'correct' => false, 'explanation' => 'Multiple lights are required to make the whole group visible from front and rear.'],
                    ['text' => 'Organised walks should not take place at night',                                                               'correct' => false, 'explanation' => 'Night walks are permitted but specific lighting requirements must be followed.'],
                ],
            ],
            [
                'category' => 'pedestrians-cyclists',
                'difficulty' => 'easy',
                'question' => 'Which of these is the safest place for a pedestrian to cross the road?',
                'answers' => [
                    ['text' => 'A pedestrian crossing',      'correct' => true,  'explanation' => 'Pedestrian crossings, traffic islands, traffic lights, and where a police officer or traffic warden is present are the safest places to cross.'],
                    ['text' => 'Between parked cars',        'correct' => false, 'explanation' => 'Crossing between parked cars is risky — drivers cannot see you until it is too late.'],
                    ['text' => 'In the middle of the road away from crossings', 'correct' => false, 'explanation' => 'Crossing away from designated points is dangerous.'],
                    ['text' => 'At a bend',                  'correct' => false, 'explanation' => 'Crossing at a bend is dangerous — oncoming drivers cannot see you in time.'],
                ],
            ],
            [
                'category' => 'pedestrians-cyclists',
                'difficulty' => 'medium',
                'question' => 'If there is no safe crossing place, what should a pedestrian do before crossing?',
                'answers' => [
                    ['text' => 'Choose a place with clear visibility in all directions and avoid crossing near parked vehicles', 'correct' => true,  'explanation' => 'When no formal crossing exists, choose a spot where you can clearly see all approaching traffic and where drivers can see you — avoid areas blocked by parked vehicles.'],
                    ['text' => 'Cross quickly anywhere to minimise time on the road',                                           'correct' => false, 'explanation' => 'Rushing across without checking visibility is dangerous regardless of speed.'],
                    ['text' => 'Always walk to the nearest junction',                                                           'correct' => false, 'explanation' => 'Junctions are not automatically safe crossing points — clear sightlines matter most.'],
                    ['text' => 'Wait for another pedestrian to cross first',                                                    'correct' => false, 'explanation' => 'Following another pedestrian does not guarantee it is safe for you.'],
                ],
            ],
            [
                'category' => 'pedestrians-cyclists',
                'difficulty' => 'medium',
                'question' => 'If you must cross between parked vehicles, where should you stop first?',
                'answers' => [
                    ['text' => 'At the outside edge of the vehicles, so you can see traffic and be seen by drivers', 'correct' => true,  'explanation' => 'Stop at the outside edge of the parked vehicles — this allows you to look all around for traffic and to be visible to drivers before stepping into the road.'],
                    ['text' => 'Step straight out from between the vehicles',                                         'correct' => false, 'explanation' => 'Stepping straight out is dangerous — drivers cannot see you until you are already in the road.'],
                    ['text' => 'Cross quickly from the middle of the gap',                                            'correct' => false, 'explanation' => 'Moving quickly without first checking from the edge gives you no information about approaching traffic.'],
                    ['text' => 'Crouch low to stay out of sight',                                                     'correct' => false, 'explanation' => 'Being seen by drivers is exactly what you want — crouching makes you less visible and more at risk.'],
                ],
            ],
            [
                'category' => 'pedestrians-cyclists',
                'difficulty' => 'easy',
                'question' => 'What does the "Don\'t Walk" symbol at a pedestrian crossing mean?',
                'answers' => [
                    ['text' => 'Do not cross when this sign is shown',    'correct' => true,  'explanation' => 'The "Don\'t Walk" symbol (usually a raised hand or red figure) means pedestrians must not cross — wait until the Walk symbol appears.'],
                    ['text' => 'Cross quickly before traffic moves',      'correct' => false, 'explanation' => 'The "Don\'t Walk" signal means wait — do not cross.'],
                    ['text' => 'Pedestrians should slow their pace',      'correct' => false, 'explanation' => '"Don\'t Walk" means stop, not slow down.'],
                    ['text' => 'The crossing is out of order',            'correct' => false, 'explanation' => '"Don\'t Walk" is a normal part of the crossing cycle — it does not indicate a fault.'],
                ],
            ],
            [
                'category' => 'pedestrians-cyclists',
                'difficulty' => 'easy',
                'question' => 'What does the "Walk" symbol at a pedestrian crossing indicate?',
                'answers' => [
                    ['text' => 'A pedestrian may cross with care',             'correct' => true,  'explanation' => 'The "Walk" symbol (usually a green walking figure) indicates pedestrians may cross — but always check traffic has stopped before stepping out.'],
                    ['text' => 'All vehicles have stopped — cross immediately', 'correct' => false, 'explanation' => 'Even with the Walk signal showing, check that all traffic has actually stopped before crossing.'],
                    ['text' => 'The crossing is busy — wait your turn',        'correct' => false, 'explanation' => '"Walk" means it is your turn to cross, not to wait.'],
                    ['text' => 'Emergency vehicles may be approaching',        'correct' => false, 'explanation' => '"Walk" is a general crossing signal — it does not specifically refer to emergency vehicles.'],
                ],
            ],
            [
                'category' => 'pedestrians-cyclists',
                'difficulty' => 'medium',
                'question' => 'The "Don\'t Walk" sign at a pedestrian crossing begins to flash. What does this mean?',
                'answers' => [
                    ['text' => 'Do not start crossing; if already crossing, you will have time to finish safely', 'correct' => true,  'explanation' => 'A flashing "Don\'t Walk" means the lights will soon change — do not begin to cross, but if you have already started, you will have enough time to finish safely.'],
                    ['text' => 'Stop immediately in the middle of the road', 'correct' => false, 'explanation' => 'If already crossing, continue to the other side — stopping in the middle is dangerous.'],
                    ['text' => 'Cross quickly before the lights change',     'correct' => false, 'explanation' => 'If you have not yet stepped out, do not start crossing — time is almost up.'],
                    ['text' => 'The crossing is unsafe for all users',       'correct' => false, 'explanation' => 'Those already crossing have time to finish safely — the signal warns those about to cross not to start.'],
                ],
            ],
            [
                'category' => 'pedestrians-cyclists',
                'difficulty' => 'easy',
                'question' => 'What should a pedestrian do if an emergency vehicle approaches with lights flashing?',
                'answers' => [
                    ['text' => 'Do not step onto the road — remain on the pavement', 'correct' => true,  'explanation' => 'Pedestrians should not step onto the road if an emergency vehicle is approaching with lights and sirens — remain safely on the pavement until it has passed.'],
                    ['text' => 'Cross quickly before the vehicle arrives',            'correct' => false, 'explanation' => 'Rushing across in front of an emergency vehicle is extremely dangerous.'],
                    ['text' => 'Wave the emergency vehicle past',                     'correct' => false, 'explanation' => 'Emergency vehicles do not need pedestrians to wave them through — stay off the road.'],
                    ['text' => 'Walk parallel to the road instead',                  'correct' => false, 'explanation' => 'The safest action is to remain on the pavement until the emergency vehicle has passed.'],
                ],
            ],

            // -------------------------------------------------------
            // SAFE DRIVING PRACTICES (Quizlet PDF additions)
            // -------------------------------------------------------
            [
                'category' => 'safe-driving-practices',
                'difficulty' => 'easy',
                'question' => 'How often is it recommended that you take a break when driving?',
                'answers' => [
                    ['text' => '15 minutes every two hours',  'correct' => true,  'explanation' => 'It is recommended to take at least a 15-minute break for every two hours of driving to prevent fatigue.'],
                    ['text' => '30 minutes every hour',       'correct' => false, 'explanation' => '30 minutes per hour is more frequent than recommended — 15 minutes every two hours is the guideline.'],
                    ['text' => '10 minutes every three hours', 'correct' => false, 'explanation' => 'Three-hour intervals without a break is too long and risks dangerous fatigue.'],
                    ['text' => '5 minutes every hour',        'correct' => false, 'explanation' => '5 minutes per hour is not the standard recommendation.'],
                ],
            ],
            [
                'category' => 'safe-driving-practices',
                'difficulty' => 'easy',
                'question' => 'In which of these conditions should you NOT drive?',
                'answers' => [
                    ['text' => 'When drowsy/unwell or under the influence of alcohol or drugs', 'correct' => true,  'explanation' => 'You must not drive when drowsy, unwell, or under the influence of alcohol or drugs — all of these seriously impair your ability to drive safely.'],
                    ['text' => 'When it is raining',         'correct' => false, 'explanation' => 'Rain alone does not prohibit driving — adjust your speed and style to the conditions.'],
                    ['text' => 'When driving at night',      'correct' => false, 'explanation' => 'Night driving is permitted — use your headlights and reduce speed as needed.'],
                    ['text' => 'When carrying a passenger',  'correct' => false, 'explanation' => 'Carrying passengers is permitted and does not disqualify you from driving.'],
                ],
            ],

            // -------------------------------------------------------
            // SPEED LIMITS (Quizlet PDF additions — kph stopping distances)
            // -------------------------------------------------------
            [
                'category' => 'speed-limits',
                'difficulty' => 'medium',
                'question' => 'What is the total stopping distance for a car travelling at 30 km/h?',
                'answers' => [
                    ['text' => '12 metres', 'correct' => true,  'explanation' => 'At 30 km/h the total stopping distance (reaction + braking) is approximately 12 metres.'],
                    ['text' => '6 metres',  'correct' => false, 'explanation' => '6 metres is only the thinking distance — total stopping distance at 30 km/h is 12 metres.'],
                    ['text' => '24 metres', 'correct' => false, 'explanation' => '24 metres is the stopping distance at 50 km/h, not 30 km/h.'],
                    ['text' => '18 metres', 'correct' => false, 'explanation' => '18 metres is not a standard stopping distance figure in the Barbados Highway Code.'],
                ],
            ],
            [
                'category' => 'speed-limits',
                'difficulty' => 'medium',
                'question' => 'What is the total stopping distance for a car travelling at 50 km/h?',
                'answers' => [
                    ['text' => '24 metres', 'correct' => true,  'explanation' => 'At 50 km/h the total stopping distance is approximately 24 metres.'],
                    ['text' => '12 metres', 'correct' => false, 'explanation' => '12 metres is the stopping distance at 30 km/h.'],
                    ['text' => '36 metres', 'correct' => false, 'explanation' => '36 metres is the stopping distance at 60 km/h.'],
                    ['text' => '18 metres', 'correct' => false, 'explanation' => '18 metres is not a standard stopping distance in the Barbados Highway Code.'],
                ],
            ],
            [
                'category' => 'speed-limits',
                'difficulty' => 'medium',
                'question' => 'What is the total stopping distance for a car travelling at 60 km/h?',
                'answers' => [
                    ['text' => '36 metres', 'correct' => true,  'explanation' => 'At 60 km/h the total stopping distance is approximately 36 metres.'],
                    ['text' => '24 metres', 'correct' => false, 'explanation' => '24 metres is the stopping distance at 50 km/h.'],
                    ['text' => '55 metres', 'correct' => false, 'explanation' => '55 metres is the stopping distance at 80 km/h.'],
                    ['text' => '48 metres', 'correct' => false, 'explanation' => '48 metres is not a standard stopping distance in the Barbados Highway Code.'],
                ],
            ],
            [
                'category' => 'speed-limits',
                'difficulty' => 'medium',
                'question' => 'What is the total stopping distance for a car travelling at 80 km/h?',
                'answers' => [
                    ['text' => '55 metres', 'correct' => true,  'explanation' => 'At 80 km/h the total stopping distance is approximately 55 metres — nearly the length of two cricket pitches.'],
                    ['text' => '36 metres', 'correct' => false, 'explanation' => '36 metres is the stopping distance at 60 km/h.'],
                    ['text' => '40 metres', 'correct' => false, 'explanation' => '40 metres is not the correct stopping distance at 80 km/h.'],
                    ['text' => '70 metres', 'correct' => false, 'explanation' => '70 metres is more than the stopping distance at 80 km/h.'],
                ],
            ],
            [
                'category' => 'speed-limits',
                'difficulty' => 'easy',
                'question' => 'What does the total stopping distance consist of?',
                'answers' => [
                    ['text' => 'Reaction distance plus braking distance', 'correct' => true,  'explanation' => 'Total stopping distance = reaction distance (travelled while your brain processes and your foot reaches the brake) + braking distance (travelled while the brakes bring the vehicle to a stop).'],
                    ['text' => 'Braking distance only',                   'correct' => false, 'explanation' => 'Total stopping distance includes both reaction distance and braking distance.'],
                    ['text' => 'Thinking time only',                      'correct' => false, 'explanation' => 'Thinking (reaction) time contributes to distance, but braking distance must also be added.'],
                    ['text' => 'Speed multiplied by time',                'correct' => false, 'explanation' => 'Stopping distance specifically = reaction distance + braking distance.'],
                ],
            ],

            // -------------------------------------------------------
            // TRAFFIC LIGHTS & SIGNALS (Quizlet PDF additions)
            // -------------------------------------------------------
            [
                'category' => 'traffic-lights-signals',
                'difficulty' => 'medium',
                'question' => 'At a traffic light, what does a red signal showing a directional arrow mean?',
                'answers' => [
                    ['text' => 'You are prohibited from entering the intersection in the direction of the arrow', 'correct' => true,  'explanation' => 'A red signal with a directional arrow prohibits you from entering the intersection and travelling in the direction the arrow points.'],
                    ['text' => 'Turn in the direction of the arrow when safe',                                    'correct' => false, 'explanation' => 'Red means stop — with or without an arrow, you may not proceed in that direction.'],
                    ['text' => 'Proceed in the direction of the arrow only',                                     'correct' => false, 'explanation' => 'A green arrow permits movement — a red arrow prohibits it.'],
                    ['text' => 'Give way to traffic in the direction of the arrow',                              'correct' => false, 'explanation' => 'A red arrow means stop — not simply give way.'],
                ],
            ],
            [
                'category' => 'traffic-lights-signals',
                'difficulty' => 'medium',
                'question' => 'What does a flashing amber arrow signal at traffic lights mean?',
                'answers' => [
                    ['text' => 'Proceed with caution only in the direction indicated by the arrow', 'correct' => true,  'explanation' => 'A flashing amber arrow means you may proceed in the direction of the arrow only, but with caution — watch for other traffic and pedestrians.'],
                    ['text' => 'Stop and wait',                           'correct' => false, 'explanation' => 'A flashing amber arrow means proceed with caution — not stop.'],
                    ['text' => 'Proceed in any direction with caution',   'correct' => false, 'explanation' => 'The arrow restricts you to its indicated direction — not any direction.'],
                    ['text' => 'The traffic light is malfunctioning',     'correct' => false, 'explanation' => 'A flashing amber arrow is a deliberate signal, not a sign of malfunction.'],
                ],
            ],
            [
                'category' => 'traffic-lights-signals',
                'difficulty' => 'medium',
                'question' => 'What is the correct hand signal for turning right or moving out to the right?',
                'answers' => [
                    ['text' => 'Extend right arm and hand horizontally with palm turned to the front', 'correct' => true,  'explanation' => 'The right turn/move right signal requires extending the right arm and hand horizontally with the palm facing forward.'],
                    ['text' => 'Extend right arm and wave it upward',                                  'correct' => false, 'explanation' => 'The correct signal is a horizontal extension with palm to the front, not an upward wave.'],
                    ['text' => 'Carry right arm forward and over the roof of the vehicle',             'correct' => false, 'explanation' => 'Carrying the arm forward and over is the left turn hand signal.'],
                    ['text' => 'Extend right arm with palm down and move it up and down',              'correct' => false, 'explanation' => 'Moving the arm up and down with palm down is the slow down/stop signal.'],
                ],
            ],
            [
                'category' => 'traffic-lights-signals',
                'difficulty' => 'medium',
                'question' => 'What is the correct hand signal for turning left?',
                'answers' => [
                    ['text' => 'Extend right arm horizontally, then carry it forward and over the top of the vehicle with palm facing down', 'correct' => true,  'explanation' => 'For a left turn, extend the right arm and hand horizontally, then carry them forward towards the nearside or upward and over the top of the vehicle with palm facing downward.'],
                    ['text' => 'Extend right arm with palm turned to the front',       'correct' => false, 'explanation' => 'Palm to the front is the right turn/moving off signal, not left.'],
                    ['text' => 'Extend left arm horizontally out of the window',       'correct' => false, 'explanation' => 'All hand signals in Barbados use the right arm.'],
                    ['text' => 'Point left with the right index finger',               'correct' => false, 'explanation' => 'The correct signal uses the full right arm, not just a pointing finger.'],
                ],
            ],
            [
                'category' => 'traffic-lights-signals',
                'difficulty' => 'medium',
                'question' => 'What is the correct hand signal for slowing down or stopping?',
                'answers' => [
                    ['text' => 'Extend right arm horizontally with palm facing down, moving it up and down slowly and repeatedly', 'correct' => true,  'explanation' => 'The slow down/stop signal: extend the right arm horizontally, turn the palm downward, and move the arm up and down slowly and repeatedly.'],
                    ['text' => 'Extend right arm with palm to the front',  'correct' => false, 'explanation' => 'Palm to the front is the right turn or moving off signal.'],
                    ['text' => 'Hold right arm straight up',               'correct' => false, 'explanation' => 'Arm straight up is not a standard Barbados Highway Code hand signal.'],
                    ['text' => 'Wave the right arm from side to side',     'correct' => false, 'explanation' => 'Side-to-side waving is not a defined hand signal for slowing down.'],
                ],
            ],
            [
                'category' => 'traffic-lights-signals',
                'difficulty' => 'easy',
                'question' => 'What is the correct hand signal for moving off from a stationary position?',
                'answers' => [
                    ['text' => 'Extend right arm and hand horizontally with palm turned to the front', 'correct' => true,  'explanation' => 'Moving off from a stationary position uses the same signal as turning right — extend the right arm horizontally with palm facing forward.'],
                    ['text' => 'Extend right arm with palm facing down and move it up and down',       'correct' => false, 'explanation' => 'Palm down and up-and-down movement is the slow down/stop signal.'],
                    ['text' => 'Carry right arm forward and over the top of the vehicle',              'correct' => false, 'explanation' => 'Carrying the arm over the vehicle is the left turn signal.'],
                    ['text' => 'Give a thumbs up out of the window',                                   'correct' => false, 'explanation' => 'A thumbs up is not a recognised hand signal in the Barbados Highway Code.'],
                ],
            ],

        ];
    }
}
