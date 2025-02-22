<?php

namespace Pashkevich\Loyverse\Actions;

use Pashkevich\Loyverse\Resources\Employee;

/**
 * Trait ManagesEmployees
 *
 * @package Pashkevich\Loyverse\Actions
 */
trait ManagesEmployees
{
    /**
     * Get a list of employees.
     *
     * @param array $parameters
     * @return array{employees: Employee[], cursor: string}
     */
    public function employees(array $parameters = []): array
    {
        $response = $this->get('employees', $parameters);

        return [
            'employees' => $this->transformCollection($response['employees'], Employee::class),
            'cursor' => $response['cursor'],
        ];
    }

    /**
     * Get a single employee.
     *
     * @param string $employeeId
     * @return Employee
     */
    public function employee(string $employeeId): Employee
    {
        return new Employee($this->get("employees/$employeeId"), $this);
    }
}
