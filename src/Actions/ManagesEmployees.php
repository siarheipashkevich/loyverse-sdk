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
     * @return Employee[]
     */
    public function employees(array $parameters = []): array
    {
        return $this->transformCollection($this->get('employees', $parameters)['employees'], Employee::class);
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
