<?php

declare(strict_types=1);

namespace Pashkevich\Loyverse\Actions;

use Pashkevich\Loyverse\Resources\Employee;

trait ManagesEmployees
{
    /**
     * Get a list of employees.
     *
     * @param  array<string, mixed>  $parameters
     * @return array<string, mixed>
     */
    public function employees(array $parameters = []): array
    {
        return $this->getPage('employees', $parameters, 'employees', Employee::class);
    }

    /**
     * Get a single employee.
     */
    public function employee(string $employeeId): Employee
    {
        return $this->getResource("employees/$employeeId", Employee::class);
    }
}
