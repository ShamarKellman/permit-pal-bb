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
            $category = Category::where('slug', $item['category'])->first();

            if (! $category) {
                continue;
            }

            $question = Question::updateOrCreate(
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
                Answer::create([
                    'question_id' => $question->id,
                    'answer_text' => $answerData['text'],
                    'is_correct' => $answerData['correct'],
                    'explanation' => $answerData['explanation'] ?? null,
                ]);
            }
        }
    }

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

        ];
    }
}
