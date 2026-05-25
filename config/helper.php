<?php

function getStatus(int $status): string
{
    return $status ? '<span class="badge bg-primary">Active</span>' : '<span class="badge bg-warning">Inactive</span>';
}

function getLabel(string $status) {}

function inputFailed($status)
{
    return "<span class='text-danger'>$status</span>";
}
