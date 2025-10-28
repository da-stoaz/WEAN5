using Microsoft.EntityFrameworkCore;

namespace PublicTransport.Entities;

public class PublicTransportE
{
    public int Id { get; set; }
    public required string TransportType { get; set; }
    public bool IsEnabled { get; set; }
    [Precision(10, 2)] public decimal HoursSinceLastService { get; set; }

    public ICollection<ServicePlan> ServicePlans { get; set; } = [];
}