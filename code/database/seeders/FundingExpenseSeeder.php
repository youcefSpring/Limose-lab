<?php

namespace Database\Seeders;

use App\Models\Funding;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FundingExpenseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $activeFunding = Funding::whereIn('status', ['active', 'completed'])->get();
        $users = User::whereIn('role', ['researcher', 'lab_manager', 'admin'])->get();

        foreach ($activeFunding as $funding) {
            // Generate 5-15 expenses per funding record
            $numExpenses = rand(5, 15);

            $totalExpenses = 0;
            $budgetUsed = $funding->budget_used ?? 0;

            for ($i = 0; $i < $numExpenses; $i++) {
                $expense = $this->generateExpense($funding, $budgetUsed, $totalExpenses);
                $user = $users->random();

                DB::table('funding_expenses')->insert([
                    'funding_id' => $funding->id,
                    'user_id' => $user->id,
                    'amount' => $expense['amount'],
                    'category' => $expense['category'],
                    'description' => $expense['description'],
                    'expense_date' => $expense['date'],
                    'vendor' => $expense['vendor'],
                    'receipt_number' => $expense['receipt_number'],
                    'payment_method' => $expense['payment_method'],
                    'approval_status' => $expense['approval_status'],
                    'approved_by' => $this->getApprover($users),
                    'approved_at' => $expense['approved_at'],
                    'reimbursement_status' => $expense['reimbursement_status'],
                    'reimbursement_date' => $expense['reimbursement_date'],
                    'budget_category' => $expense['budget_category'],
                    'project_code' => $funding->grant_number,
                    'tax_amount' => $expense['tax_amount'],
                    'notes' => $expense['notes'],
                    'receipt_url' => $expense['receipt_url'],
                    'created_at' => $expense['date'],
                    'updated_at' => now(),
                ]);

                $totalExpenses += $expense['amount'];

                // Don't exceed the budget used
                if ($totalExpenses >= $budgetUsed) {
                    break;
                }
            }
        }
    }

    private function generateExpense($funding, float $budgetUsed, float $currentTotal): array
    {
        $remainingBudget = $budgetUsed - $currentTotal;
        $maxAmount = min($remainingBudget, 50000); // Cap individual expenses at $50K

        $categories = ['personnel', 'equipment', 'supplies', 'travel', 'indirect_costs', 'other'];
        $category = $categories[array_rand($categories)];

        $amount = $this->generateAmount($category, $maxAmount);
        $date = $this->generateExpenseDate($funding);

        return [
            'amount' => $amount,
            'category' => $category,
            'description' => $this->generateDescription($category),
            'date' => $date,
            'vendor' => $this->generateVendor($category),
            'receipt_number' => $this->generateReceiptNumber(),
            'payment_method' => $this->generatePaymentMethod(),
            'approval_status' => 'approved',
            'approved_at' => $date,
            'reimbursement_status' => $this->generateReimbursementStatus(),
            'reimbursement_date' => $this->generateReimbursementDate($date),
            'budget_category' => $category,
            'tax_amount' => $amount * 0.08, // 8% tax
            'notes' => $this->generateNotes($category),
            'receipt_url' => $this->generateReceiptUrl(),
        ];
    }

    private function generateAmount(string $category, float $maxAmount): float
    {
        $ranges = [
            'personnel' => [5000, min(25000, $maxAmount)],
            'equipment' => [1000, min(15000, $maxAmount)],
            'supplies' => [50, min(2000, $maxAmount)],
            'travel' => [500, min(5000, $maxAmount)],
            'indirect_costs' => [1000, min(10000, $maxAmount)],
            'other' => [100, min(3000, $maxAmount)],
        ];

        $range = $ranges[$category] ?? [100, min(1000, $maxAmount)];
        $min = $range[0];
        $max = max($min, $range[1]);

        return round(rand($min * 100, $max * 100) / 100, 2);
    }

    private function generateExpenseDate($funding): string
    {
        $startDate = new \DateTime($funding->start_date);
        $endDate = min(new \DateTime($funding->end_date), now());

        $randomTimestamp = rand($startDate->getTimestamp(), $endDate->getTimestamp());
        return (new \DateTime())->setTimestamp($randomTimestamp)->format('Y-m-d H:i:s');
    }

    private function generateDescription(string $category): string
    {
        $descriptions = [
            'personnel' => [
                'Graduate student stipend - Month of March',
                'Postdoctoral researcher salary',
                'Research technician wages',
                'Principal investigator effort',
                'Student research assistant hourly wages',
            ],
            'equipment' => [
                'Microscope objective lens purchase',
                'Laboratory centrifuge acquisition',
                'Computer workstation for data analysis',
                'Specialized measurement instrument',
                'Safety cabinet installation',
            ],
            'supplies' => [
                'Cell culture media and reagents',
                'Laboratory glassware and plasticware',
                'Chemical compounds for experiments',
                'DNA/RNA extraction kits',
                'Antibodies for immunofluorescence',
            ],
            'travel' => [
                'Conference registration and travel - Annual Meeting',
                'Collaboration visit to partner institution',
                'Field work transportation costs',
                'Workshop attendance travel expenses',
                'International conference participation',
            ],
            'indirect_costs' => [
                'University overhead charges',
                'Administrative cost allocation',
                'Facility usage fees',
                'Institutional support costs',
                'General administrative expenses',
            ],
            'other' => [
                'Publication fees for open access',
                'Software license renewal',
                'Data storage and backup services',
                'Patent application fees',
                'Ethics committee review costs',
            ],
        ];

        $categoryDescriptions = $descriptions[$category] ?? ['General research expense'];
        return $categoryDescriptions[array_rand($categoryDescriptions)];
    }

    private function generateVendor(string $category): string
    {
        $vendors = [
            'personnel' => 'University Payroll',
            'equipment' => [
                'Thermo Fisher Scientific',
                'Bio-Rad Laboratories',
                'Olympus Corporation',
                'Agilent Technologies',
                'Waters Corporation',
            ],
            'supplies' => [
                'VWR International',
                'Fisher Scientific',
                'Sigma-Aldrich',
                'Life Technologies',
                'Promega Corporation',
            ],
            'travel' => [
                'American Airlines',
                'Delta Airlines',
                'Marriott Hotels',
                'Hilton Hotels',
                'Enterprise Rent-A-Car',
            ],
            'indirect_costs' => 'University Administration',
            'other' => [
                'Nature Publishing Group',
                'Elsevier',
                'Microsoft Corporation',
                'Adobe Systems',
                'Amazon Web Services',
            ],
        ];

        $categoryVendors = $vendors[$category] ?? ['General Vendor'];

        if (is_array($categoryVendors)) {
            return $categoryVendors[array_rand($categoryVendors)];
        }

        return $categoryVendors;
    }

    private function generateReceiptNumber(): string
    {
        return 'RCP-' . date('Y') . '-' . rand(100000, 999999);
    }

    private function generatePaymentMethod(): string
    {
        $methods = ['credit_card', 'purchase_order', 'wire_transfer', 'check', 'electronic_transfer'];
        return $methods[array_rand($methods)];
    }

    private function generateReimbursementStatus(): string
    {
        $statuses = ['pending', 'approved', 'paid', 'not_required'];
        $weights = [10, 20, 60, 10]; // Most are paid

        $random = rand(1, 100);
        $cumulative = 0;

        foreach ($weights as $index => $weight) {
            $cumulative += $weight;
            if ($random <= $cumulative) {
                return $statuses[$index];
            }
        }

        return 'paid';
    }

    private function generateReimbursementDate(?string $expenseDate): ?string
    {
        if (rand(0, 3) === 0) { // 25% chance of no reimbursement date
            return null;
        }

        $expense = new \DateTime($expenseDate);
        $expense->add(new \DateInterval('P' . rand(7, 30) . 'D')); // 7-30 days later

        return $expense->format('Y-m-d H:i:s');
    }

    private function generateNotes(string $category): ?string
    {
        if (rand(0, 2) === 0) { // 33% chance of notes
            $notes = [
                'personnel' => 'Approved by department head',
                'equipment' => 'Installation and training included',
                'supplies' => 'Bulk order discount applied',
                'travel' => 'Conference proceedings included',
                'indirect_costs' => 'Standard university rate applied',
                'other' => 'Supporting research activities',
            ];

            return $notes[$category] ?? null;
        }

        return null;
    }

    private function generateReceiptUrl(): ?string
    {
        if (rand(0, 1) === 0) { // 50% chance of receipt URL
            return 'https://sglr.com/receipts/' . rand(100000, 999999) . '.pdf';
        }

        return null;
    }

    private function getApprover($users): ?int
    {
        $approvers = $users->whereIn('role', ['admin', 'lab_manager']);
        return $approvers->isNotEmpty() ? $approvers->random()->id : null;
    }
}