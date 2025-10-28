using Microsoft.EntityFrameworkCore;

namespace RazorMSTutorial.Models;

public class PublicTransport
{
    public int Id { get; set; }
    public required string TransportType { get; set; }
    public bool IsEnabled { get; set; }
    [Precision(10, 2)] public decimal HoursSinceLastService { get; set; }

    public ICollection<ServicePlan> ServicePlans { get; set; } = [];
}