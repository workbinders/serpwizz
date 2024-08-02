<?php

namespace Database\Seeders;

use App\Models\Features;
use App\Models\Plan;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class PlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //plans
        $plansData = [
            [
                Plan::NAME  => 'Muggle',
                Plan::MONTHLY_PRICE => 0,
                Plan::ANNAL_PRICE => 0,
                Plan::DESCRIPTION => NULL,
                Plan::ORDERING  => 1,
                Plan::HIGHLIGHT => false,
                'features' => [
                    [
                        Features::NAME => 'Free access to all SERPwizz tools',
                        Features::SLUG => Str::slug(strtoupper('free access to all SERPwizz tools')),
                        Features::VALUE => 'keywords',
                        Features::ORDERING => 1,
                    ],
                    [
                        Features::NAME => 'Unlimited website/lead audits',
                        Features::SLUG => Str::slug(strtoupper('unlimited website/lead audits')),
                        Features::VALUE => 'keywords',
                        Features::ORDERING => 2,

                    ],
                    [
                        Features::NAME => 'PDF report download',
                        Features::SLUG => Str::slug('pdf report download'),
                        Features::VALUE => 'keywords',
                        Features::ORDERING => 3,

                    ],
                    [
                        Features::NAME => 'Rank checker',
                        Features::SLUG => Str::slug(strtoupper('rank checker')),
                        Features::VALUE => 'keywords',
                        Features::ORDERING => 4,
                    ],
                ]
            ],
            [
                Plan::NAME  => 'Mage',
                Plan::SLUG  => Str::slug('Mage'),
                Plan::MONTHLY_PRICE => 19,
                Plan::ANNAL_PRICE => 190,
                Plan::DESCRIPTION => NULL,
                Plan::ORDERING  => 2,
                Plan::HIGHLIGHT => true,
                'features' => [
                    [
                        Features::NAME => 'Free access to all SERPwizz tools',
                        Features::SLUG => Str::slug(strtoupper('free access to all SERPwizz tools')),
                        Features::VALUE => 'keywords',
                        Features::ORDERING => 1,

                    ],
                    [
                        Features::NAME => 'Unlimited website/lead audits',
                        Features::SLUG => Str::slug(strtoupper('unlimited website/lead audits')),
                        Features::VALUE => 'keywords',
                        Features::ORDERING => 2,

                    ],
                    [
                        Features::NAME => 'PDF report download',
                        Features::SLUG => Str::slug('pdf report download'),
                        Features::VALUE => 'keywords',
                        Features::ORDERING => 3,

                    ],
                    [
                        Features::NAME => 'Team members',
                        Features::SLUG => Str::slug(strtoupper('team members')),
                        Features::VALUE => 'keywords',
                        Features::ORDERING => 4,

                    ],
                    [
                        Features::NAME => 'Audit reports',
                        Features::SLUG => Str::slug(strtoupper('audit reports')),
                        Features::VALUE => 'keywords',
                        Features::ORDERING => 5,

                    ],
                    [
                        Features::NAME => 'Rank checker',
                        Features::SLUG => Str::slug(strtoupper('rank checker')),
                        Features::VALUE => 'keywords',
                        Features::ORDERING => 6,

                    ],
                ]
            ],
            [
                Plan::NAME  => 'Magician',
                Plan::SLUG  => Str::slug('Magician'),
                Plan::MONTHLY_PRICE => 49,
                Plan::ANNAL_PRICE => 490,
                Plan::DESCRIPTION => NULL,
                Plan::ORDERING  => 3,
                Plan::HIGHLIGHT => true,
                'features' => [
                    [
                        Features::NAME => 'Free access to all SERPwizz tools',
                        Features::SLUG => Str::slug(strtoupper('free access to all SERPwizz tools')),
                        Features::VALUE => 'keywords',
                        Features::ORDERING => 1,
                    ],
                    [
                        Features::NAME => 'Unlimited website/lead audits',
                        Features::SLUG => Str::slug(strtoupper('unlimited website/lead audits')),
                        Features::VALUE => 'keywords',
                        Features::ORDERING => 2,
                    ],
                    [
                        Features::NAME => 'PDF report download',
                        Features::SLUG => Str::slug('pdf report download'),
                        Features::VALUE => 'keywords',
                        Features::ORDERING => 3,
                    ],
                    [
                        Features::NAME => 'Team members',
                        Features::SLUG => Str::slug(strtoupper('team members')),
                        Features::VALUE => 'keywords',
                        Features::ORDERING => 4,
                    ],
                    [
                        Features::NAME => 'Audit reports',
                        Features::SLUG => Str::slug(strtoupper('audit reports')),
                        Features::VALUE => 'keywords',
                        Features::ORDERING => 5,

                    ],
                    [
                        Features::NAME => 'Rank checker',
                        Features::SLUG => Str::slug(strtoupper('rank checker')),
                        Features::VALUE => 'keywords',
                        Features::ORDERING => 6,

                    ],
                    [
                        Features::NAME => 'Embed Audit Tool',
                        Features::SLUG => Str::slug(strtoupper('embed audit tool')),
                        Features::VALUE => 'keywords',
                        Features::ORDERING => 7,
                    ],
                    [
                        Features::NAME => 'White Label',
                        Features::SLUG => Str::slug(strtoupper('white label')),
                        Features::VALUE => 'keywords',
                        Features::ORDERING => 8,

                    ],
                ]
            ],
            [
                Plan::NAME  => 'Wizard',
                Plan::SLUG  => Str::slug('Wizard'),
                Plan::MONTHLY_PRICE => 99,
                Plan::ANNAL_PRICE => 990,
                Plan::DESCRIPTION => NULL,
                Plan::ORDERING  => 4,
                Plan::HIGHLIGHT => false,
                'features' => [
                    [
                        Features::NAME => 'Free access to all SERPwizz tools',
                        Features::SLUG => Str::slug(strtoupper('free access to all SERPwizz tools')),
                        Features::VALUE => 'keywords',
                        Features::ORDERING => 1,
                    ],
                    [
                        Features::NAME => 'Unlimited website/lead audits',
                        Features::SLUG => Str::slug(strtoupper('unlimited website/lead audits')),
                        Features::VALUE => 'keywords',
                        Features::ORDERING => 2,
                    ],
                    [
                        Features::NAME => 'PDF report download',
                        Features::SLUG => Str::slug('pdf report download'),
                        Features::VALUE => 'keywords',
                        Features::ORDERING => 3,
                    ],
                    [
                        Features::NAME => 'Team members',
                        Features::SLUG => Str::slug(strtoupper('team members')),
                        Features::VALUE => 'keywords',
                        Features::ORDERING => 4,

                    ],
                    [
                        Features::NAME => 'Audit reports',
                        Features::SLUG => Str::slug(strtoupper('audit reports')),
                        Features::VALUE => 'keywords',
                        Features::ORDERING => 5,
                    ],
                    [
                        Features::NAME => 'Rank checker',
                        Features::SLUG => Str::slug(strtoupper('rank checker')),
                        Features::VALUE => 'keywords',
                        Features::ORDERING => 6,

                    ],
                    [
                        Features::NAME => 'Embed Audit Tool',
                        Features::SLUG => Str::slug(strtoupper('embed audit tool')),
                        Features::VALUE => 'keywords',
                        Features::ORDERING => 7,
                    ],
                    [
                        Features::NAME => 'White Label',
                        Features::SLUG => Str::slug(strtoupper('white label')),
                        Features::VALUE => 'keywords',
                        Features::ORDERING => 8,
                    ],

                    [
                        Features::NAME => 'Free Tools(member are)',
                        Features::SLUG => Str::slug(strtoupper('free tools(member are)')),
                        Features::VALUE => 'keywords',
                        Features::ORDERING => 9,
                    ],
                ]

            ],
        ];

        foreach ($plansData as $planData) {
            $input = [
                Plan::NAME => $planData[Plan::NAME],
                Plan::SLUG => Str::slug($planData[Plan::NAME]),
                Plan::ANNAL_PRICE => $planData[Plan::ANNAL_PRICE],
                Plan::MONTHLY_PRICE => $planData[Plan::MONTHLY_PRICE],
                Plan::DESCRIPTION => $planData[Plan::DESCRIPTION],
                Plan::HIGHLIGHT => $planData[Plan::HIGHLIGHT],
                Plan::ORDERING => $planData[Plan::ORDERING],
                Plan::CREATED_AT => date('Y-m-d H:i:s'),
            ];
            if (!Plan::where('slug', $planData[Plan::NAME])->first()) {
                $Plan = Plan::create($input);
                foreach ($planData['features'] as $feature) {
                    $features = Features::updateOrCreate(
                        [
                            Features::NAME => $feature[Features::NAME]
                        ],
                        [
                            Features::SLUG => $feature[Features::SLUG],
                            Features::VALUE => $feature[Features::VALUE],
                            Features::ORDERING => $feature[Features::ORDERING],
                        ]
                    );
                    $Plan->planFeatures()->attach($features->id);
                }
            }
        }
    }
}
